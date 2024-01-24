(function () {
  // Boton para mostrar el modal de agregar tarea
  const newTaskBtn = document.querySelector("#add-task");
  newTaskBtn.addEventListener("click", showForm);

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

    try {
      const url = "http://localhost:3000/api/task";
      const response = await fetch(url, {
        method: "POST",
        body: data,
      });

      const result = await response.json();
      console.log(result);
    } catch (error) {
      console.log(error);
    }
  }
})();
