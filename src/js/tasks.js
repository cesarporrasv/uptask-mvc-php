(function () {
  getTasks();

  // Boton para mostrar el modal de agregar tarea
  const newTaskBtn = document.querySelector("#add-task");
  newTaskBtn.addEventListener("click", showForm);

  async function getTasks() {
    try {
      const id = getProject();
      const url = `/api/tasks?id=${id}`;
      const response = await fetch(url);
      const output = await response.json();
      const { tasks } = output;

      showTasks(tasks);
    } catch (error) {
      console.log(error);
    }
  }

  function showTasks(tasks) {
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

      const optionsDiv = document.createElement("DIV");
      optionsDiv.classList.add("options");

      // Botones
      const btnTaskStatus = document.createElement("BUTTON");
      btnTaskStatus.classList.add("task-status");
      btnTaskStatus.classList.add(`${status[task.status].toLowerCase()}`);
      btnTaskStatus.textContent = status[task.status];
      btnTaskStatus.dataset.taskStatus = task.status;

      const btnDeleteTask = document.createElement("BUTTON");
      btnDeleteTask.classList.add("delete-task");
      btnDeleteTask.dataset.idTask = task.id;
      btnDeleteTask.textContent = "Eliminar";

      optionsDiv.appendChild(btnTaskStatus);
      optionsDiv.appendChild(btnDeleteTask);

      taskContainer.appendChild(taskName);
      taskContainer.appendChild(optionsDiv);

      const tasksList = document.querySelector("#tasks-list");
      tasksList.appendChild(taskContainer);
    });
  }

  function showForm() {
    const modal = document.createElement("DIV");
    modal.classList.add("modal");
    modal.innerHTML = `
      <form class="form new-task">
        <legend>Añade una nueva Tarea</legend>
        <div class="field">
          <label>Tarea</label>
          <input
            type="text"
            name="task"
            placeholder="Añade una tarea al Proyecto"
            id="task"
          />
        </div>
        <div class="options">
          <input type="submit" class="submit-new-task" value="Añadir Tarea" />
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
        submitFormNewTask();
      }
    });

    document.querySelector(".dashboard").appendChild(modal);
  }

  function submitFormNewTask() {
    const task = document.querySelector("#task").value.trim();

    if (task === "") {
      // Mostrar alerta de error
      showAlert(
        "Debes agregar un nombre a la tarea",
        "error",
        document.querySelector(".form legend")
      );
      return;
    }

    addTask(task);
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
    }, 5000);
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
      console.log(output);

      showAlert(
        output.message,
        output.type,
        document.querySelector(".form legend")
      );

      if (output.type === "success") {
        const modal = document.querySelector(".modal");
        setTimeout(() => {
          modal.remove();
        }, 2000);
      }
    } catch (error) {
      console.log(error);
    }
  }

  function getProject() {
    const projectParams = new URLSearchParams(window.location.search);
    const project = Object.fromEntries(projectParams.entries());
    return project.id;
  }
})();
