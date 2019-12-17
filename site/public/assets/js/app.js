window.onload = () => {
  setTimeout(() => {
    $("body").attr("data-load", "true");
  }, 100);
};

window.onunload = () => {
  $("body").attr("data-load", "false");
};

const app = {
  btn: {
    btnSave: true,
    disableButtonSave: () => {
      window.default.btnSave = false;
      $("#save").attr("disabled", true);
      $("#save").html("...");
    },
    enableButtonSave: () => {
      window.default.btnSave = true;
      $("#save").attr("disabled", false);
      $("#save").html("Salvar");
    }
  },
  editor: false,
  grid: {
    lexer: {
      populate: (values) => {
        $("[data-values-lexer=\"true\"]").html("");
        $.each(values, function(key, value) {
          $("[data-values-lexer=\"true\"]").append(`
            <tr>
              <th scope="row">${value.key}</th>
              <td>${value.id}</td>
              <td>${value.name}</td>
              <td>${value.value}</td>
            </tr>
          `);
        });
      }
    },
    parser: {
      populate: (values) => {
        $("[data-values-parser=\"true\"]").html("");
        $.each(values, function(key, value) {
          $("[data-values-parser=\"true\"]").append(`
            <tr>
              <th scope="row">${(key+1)}</th>
              <td>${value}</td>
            </tr>
          `);
        });
      }
    }
  },
  run: () => {
    window.default.editor = CodeMirror.fromTextArea(document.getElementById("default-text"), {
      lineNumbers: true,
      styleActiveLine: true,
      matchBrackets: true,
      theme: "dracula",
      styleMaxHeight: "100px"
    });

    $("#save").click(function(e) {
      e.preventDefault();
      e.stopPropagation();
      if(window.default.btn.btnSave) {
        window.default.btn.disableButtonSave();

        axios.post(`${config.api.url}/save.php`, {
          values: window.default.editor.getValue()
        })
          .then((response) => {
            if(response.data.status) {
              window.default.grid.lexer.populate(response.data.values.lexer);
              window.default.grid.parser.populate(response.data.values.parser);
            }
            else {
              alert(response.data.error);
            }
            window.default.btn.enableButtonSave();
          })
          .catch((error) => {
            alert(error.response.data.error);
            window.default.btn.enableButtonSave();
          });
      }
    });

    if(window.default.btn.btnSave) {
      window.default.btn.disableButtonSave();
      axios.get(`${config.api.url}/read.php`)
        .then((response) => {
          if(response.data.status) {
            window.default.grid.lexer.populate(response.data.values.lexer);
            window.default.grid.parser.populate(response.data.values.parser);
          }
          else {
            alert(response.data.error);
          }
          window.default.btn.enableButtonSave();
        })
        .catch((error) => {
          alert(error.response.data.error);
          window.default.btn.enableButtonSave();
        });
    }
  }
};
