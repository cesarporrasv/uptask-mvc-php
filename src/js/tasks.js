(function () {
  getTasks();
  let tasks = [];

  // Boton para mostrar el modal de agregar tarea
  const newTaskBtn = document.querySelector("#add-task");
  newTaskBtn.addEventListener("click", function () {
    showForm();
  });

  async function getTasks() {
    try {
      const id = getProject();
      const url = `/api/tasks?id=${id}`;
      const response = await fetch(url);
      const output = await response.json();

      tasks = output.tasks;
      showTasks();
    } catch (error) {
      console.log(error);
    }
  }

  function showTasks() {
    cleanTasks();
    if (tasks.length === 0) {
      const tasksContainer = document.querySelector("#tasks-list");

      const noTasksText = document.createElement("LI");
      noTasksText.textContent = "No Hay Tareas";
      noTasksText.classList.add("no-tasks");

      tasksContainer.appendChild(noTasksText);
      return;
    }

    const status = {
      0: "Pendiente",
      1: "Completa",
    };
    tasks.forEach((task) => {
      const taskContainer = document.createElement("LI");
      taskContainer.dataset.taskId = task.id;
      taskContainer.classList.add("task");

      const taskName = document.createElement("P");
      taskName.textContent = task.name;
      taskName.ondblclick = function () {
        showForm((edit = true), { ...task });
      };

      const optionsDiv = document.createElement("DIV");
      optionsDiv.classList.add("options");

      // Botones
      const btnTaskStatus = document.createElement("BUTTON");
      btnTaskStatus.classList.add("task-status");
      btnTaskStatus.classList.add(`${status[task.status].toLowerCase()}`);
      btnTaskStatus.textContent = status[task.status];
      btnTaskStatus.dataset.taskStatus = task.status;
      btnTaskStatus.ondblclick = function () {
        changeTaskStatus({ ...task });
      };

      const btnDeleteTask = document.createElement("BUTTON");
      btnDeleteTask.classList.add("delete-task");
      btnDeleteTask.dataset.idTask = task.id;
      btnDeleteTask.textContent = "Eliminar";
      btnDeleteTask.ondblclick = function () {
        confirmDeleteTask({ ...task });
      };

      optionsDiv.appendChild(btnTaskStatus);
      optionsDiv.appendChild(btnDeleteTask);

      taskContainer.appendChild(taskName);
      taskContainer.appendChild(optionsDiv);

      const tasksList = document.querySelector("#tasks-list");
      tasksList.appendChild(taskContainer);
    });
  }

  function showForm(edit = false, task = {}) {
    const modal = document.createElement("DIV");
    modal.classList.add("modal");
    modal.innerHTML = `
      <form class="form new-task">
        <legend>${
          edit ? "Editar nombre tarea" : "Añade un nueva tarea"
        }</legend>
        <div class="field">
          <label>Tarea</label>
          <input
            type="text"
            name="task"
            placeholder="${
              task.name ? "Edita el nombre" : "Añade una tarea al Proyecto"
            }"
            id="task"
            value="${task.name ? task.name : ""}"
          />
        </div>
        <div class="options">
          <input 
            type="submit" 
            class="submit-new-task" 
            value="${task.name ? "Guardar Cambios" : "Añadir Tarea"}" 
          />
          <button type="button" class="close-modal">Cancelar</button>
        </div>
      </form>
    `;
    setTimeout(() => {
      const form = document.querySelector(".form");
      form.classList.add("animate");
    }, 150);

    modal.addEventListener("click", function (e) {
      e.preventDefault();
      if (e.target.classList.contains("close-modal")) {
        const form = document.querySelector(".form");
        form.classList.add("close");
        setTimeout(() => {
          modal.remove();
        }, 400);
      }
      if (e.target.classList.contains("submit-new-task")) {
        const taskName = document.querySelector("#task").value.trim();

        if (taskName === "") {
          // Mostrar alerta de error
          showAlert(
            "Debes agregar un nombre a la tarea",
            "error",
            document.querySelector(".form legend")
          );
          return;
        }

        if (edit) {
          task.name = taskName;
          updateTask(task);
        } else {
          addTask(taskName);
        }
      }
    });

    document.querySelector(".dashboard").appendChild(modal);
  }

  // Muestra un mensaje en la interfaz
  function showAlert(message, type, reference) {
    // Previene la creacion de multiples alertas
    const previousAlert = document.querySelector(".alert");
    if (previousAlert) {
      previousAlert.remove();
    }

    const alert = document.createElement("DIV");
    alert.classList.add("alert", type);
    alert.textContent = message;

    // Inserta la alerta antes del legend
    reference.parentElement.insertBefore(alert, reference.nextElementSibling);

    // Eliminar alerta despues de 5 seg
    setTimeout(() => {
      alert.remove();
    }, 2500);
  }

  // Consultar servidor para añadir una nueva tarea
  async function addTask(task) {
    // Construir la peticion
    const data = new FormData();
    data.append("name", task);
    data.append("projectId", getProject());

    try {
      const url = "http://localhost:3000/api/task";
      const response = await fetch(url, {
        method: "POST",
        body: data,
      });

      const output = await response.json();

      Swal.fire("Agregada!", output.message, "success");

      if (output.type === "success") {
        const modal = document.querySelector(".modal");
        setTimeout(() => {
          modal.remove();
        }, 2000);

        // Agregar el Objeto de tarea al global de tareas
        const taskObj = {
          id: String(output.id),
          name: task,
          status: "0",
          projectId: output.projectId,
        };
        tasks = [...tasks, taskObj];
        showTasks();
      }
    } catch (error) {
      console.log(error);
    }
  }

  function changeTaskStatus(task) {
    const newStatus = task.status === "1" ? "0" : "1";
    task.status = newStatus;
    updateTask(task);
  }

  async function updateTask(task) {
    const { status, id, name, projectId } = task;

    const data = new FormData();
    data.append("id", id);
    data.append("name", name);
    data.append("status", status);
    data.append("projectId", getProject());

    // Comprobar datos antes de enviar el servidor
    // for (let value of data.values()) {
    //   console.log(value);
    // }

    try {
      const url = "http://localhost:3000/api/task/update";

      const response = await fetch(url, {
        method: "POST",
        body: data,
      });
      const output = await response.json();

      // console.log(output);

      if (output.response.type === "success") {
        Swal.fire("Actualizada!", output.response.message, "success");

        const modal = document.querySelector(".modal");
        if (modal) {
          modal.remove();
        }

        tasks = tasks.map((taskMem) => {
          if (taskMem.id === id) {
            taskMem.status = status;
            taskMem.name = name;
          }

          return taskMem;
        });

        showTasks();
      }
    } catch (error) {
      console.log(error);
    }
  }

  function confirmDeleteTask(task) {
    Swal.fire({
      title: "Eliminar Tarea?",
      showCancelButton: true,
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        deleteTask(task);
      }
    });
  }

  async function deleteTask(task) {
    const { status, id, name } = task;

    const data = new FormData();
    data.append("id", id);
    data.append("name", name);
    data.append("status", status);
    data.append("projectId", getProject());

    try {
      const url = "http://localhost:3000/api/task/delete";
      const response = await fetch(url, {
        method: "POST",
        body: data,
      });

      const output = await response.json();
      if (output.output) {
        Swal.fire("Eliminada!", output.message, "success");

        tasks = tasks.filter((taskMem) => taskMem.id !== task.id);
        showTasks();
      }
    } catch (error) {}
  }

  function getProject() {
    const projectParams = new URLSearchParams(window.location.search);
    const project = Object.fromEntries(projectParams.entries());
    return project.id;
  }

  function cleanTasks() {
    const tasksList = document.querySelector("#tasks-list");

    while (tasksList.firstChild) {
      tasksList.removeChild(tasksList.firstChild);
    }
  }
})();
