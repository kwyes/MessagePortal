var massEmailFormObject = {};

$(document).ready(function () {
  $(document).on("click", ".cta", function () {
    $(this).toggleClass("active");
  });

});

function showSwal(type, title) {
  if (type == "error") {
    swal({ title: title, buttonsStyling: false, confirmButtonClass: "btn btn-info" }).catch(swal.noop);
  } else if (type == "success") {
    swal({ title: "Success!", buttonsStyling: false, confirmButtonClass: "btn btn-info", type: "success" }).then(function () {
      // location.reload();
    }).catch(swal.noop);
  }
}

function formatDate(date) {
  var year = date.getFullYear();
  var month = date.getMonth() + 1 < 10
    ? "0" + date.getMonth() + 1
    : date.getMonth() + 1;
  var day = date.getDate() < 10
    ? "0" + date.getDate()
    : date.getDate();
  var hour = date.getHours() < 10
    ? "0" + date.getHours()
    : date.getHours();
  var min = date.getMinutes() < 10
    ? "0" + date.getMinutes()
    : date.getMinutes();

  return year + "-" + month + "-" + day + " " + hour + ":" + min;
} (function () {
  "use strict";
  var $ = jQuery;
  $.fn.extend({
    filterTable: function () {
      return this.each(function () {
        $(this).on("keyup", function (e) {
          var $this = $(this),
            search = $this.val().toLowerCase(),
            target = $this.attr("data-filters"),
            $rows = $(target).find("tbody tr");
          if (search == "") {
            $rows.show();
          } else {
            $rows.each(function () {
              var $this = $(this);
              $this.text().toLowerCase().indexOf(search) === -1
                ? $this.hide()
                : $this.show();
            });
          }
        });
      });
    }
  });
  $('[data-action="filter"]').filterTable();
})(jQuery);

$(function () {
  // attach table filter plugin to inputs
  $('[data-action="filter"]').filterTable();

  $(".container").on("click", ".panel-heading span.filter", function (e) {
    var $this = $(this),
      $panel = $this.parents(".panel");

    $panel.find(".panel-body").slideToggle();
    if ($this.css("display") != "none") {
      $panel.find(".panel-body input").focus();
    }
  });
  $('[data-toggle="tooltip"]').tooltip();
});

function dateTimePicker() {
  if ($(".datetimepicker").length != 0) {
    $(".datetimepicker").datetimepicker({
      ignoreReadonly: true,
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: "fa fa-chevron-left",
        next: "fa fa-chevron-right",
        today: "fa fa-screenshot",
        clear: "fa fa-trash",
        close: "fa fa-remove"
      }
    });
  }

  if ($(".datepicker").length != 0) {
    $(".datepicker").datetimepicker({
      ignoreReadonly: true,
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: "fa fa-chevron-left",
        next: "fa fa-chevron-right",
        today: "fa fa-screenshot",
        clear: "fa fa-trash",
        close: "fa fa-remove"
      }
    });
  }
}

function setFormValidation(id) {
  $(id).validate({
    onclick: false,
    rules: {
      category: {
        required: true
      },
      publishCheck: {
        required: function (element) {
          var boxes = $(".publishTo");
          if (boxes.filter(":checked").length == 0) {
            return true;
          }
          return false;
        }
      },
      title: {
        required: true
      },
      subject: {
        required: true
      },
      edate: {
        required: true
      },
      expiryDate: {
        required: true
      },
      publishAt: {
        required: true
      }
    },
    highlight: function (element) {
      $(element).closest(".form-group").removeClass("has-success").addClass("has-danger");
      $(element).closest(".form-check").removeClass("has-success").addClass("has-danger");
    },
    success: function (element) {
      $(element).closest(".form-group").removeClass("has-danger").addClass("has-success");
      $(element).closest(".form-check").removeClass("has-danger").addClass("has-success");
    },
    errorPlacement: function (error, element) {
      $(element).closest(".form-group").append(error);
    }
  });
}

function clearFormValidation(form_id) {
  var input_text = form_id + ' [type="text"]';
  $(input_text).closest(".form-group").removeClass("has-danger").addClass("has-success");
  $(input_text).closest(".form-check").removeClass("has-danger").addClass("has-success");

  var input_num = form_id + ' [type="number"]';
  $(input_num).closest(".form-group").removeClass("has-danger").addClass("has-success");
  $(input_num).closest(".form-check").removeClass("has-danger").addClass("has-success");

  var input_num = form_id + ' [type="email"]';
  $(input_num).closest(".form-group").removeClass("has-danger").addClass("has-success");
  $(input_num).closest(".form-check").removeClass("has-danger").addClass("has-success");

  var input_num = form_id + " textarea";
  $(input_num).closest(".form-group").removeClass("has-danger").addClass("has-success");
  $(input_num).closest(".form-check").removeClass("has-danger").addClass("has-success");

  var input_num = form_id + " select";
  $(input_num).closest(".form-group").removeClass("has-danger").addClass("has-success");
  $(input_num).closest(".form-check").removeClass("has-danger").addClass("has-success");
  $(".error").remove();
}

function clearForm(form) {
  $(form).find('input[type="text"], textarea, select').val("");
  $(form).find('input[type="radio"]:checked').attr("checked", false);
}

function toggleSpinner() {
  if ($(".mask").is(":hidden")) {
    $(".mask").show();
  } else {
    $(".mask").hide();
  }
}

function dateTimePicker() {
  if ($(".datetimepicker").length != 0) {
    $(".datetimepicker").datetimepicker({
      // debug: true,
      ignoreReadonly: true,
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: "fa fa-chevron-left",
        next: "fa fa-chevron-right",
        today: "fa fa-screenshot",
        clear: "fa fa-trash",
        close: "fa fa-remove"
      }
    }).on("dp.change", function () { });
    $(".datetimepicker").attr("readonly", "readonly");
  }

  if ($(".datepicker").length != 0) {
    $(".datepicker").datetimepicker({
      // debug: true,
      // readonly: true,
      ignoreReadonly: true,
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: "fa fa-chevron-left",
        next: "fa fa-chevron-right",
        today: "fa fa-screenshot",
        clear: "fa fa-trash",
        close: "fa fa-remove"
      }
    }).on("dp.change", function (event) {

    });
    $(".datepicker").attr("readonly", "readonly");
  }
}
