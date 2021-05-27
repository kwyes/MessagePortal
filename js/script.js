var globalMsgList;
var globalParentsEmailList;
function strip(html) {
  var tmp = document.implementation.createHTMLDocument("New").body;
  tmp.innerHTML = html;
  return tmp.textContent || tmp.innerText || "";
}

function sendMessage(arr, massEmailFormObject) {
  toggleSpinner();
  // console.log(arr);
  // console.log(massEmailFormObject.toType);
  $.ajax({
    url: "ajax_php/a.sendEmail.php",
    type: "POST",
    dataType: "json",
    data: {
      emailArr: JSON.stringify(arr),
      type: massEmailFormObject.type,
      toType: massEmailFormObject.toType,
      category: massEmailFormObject.category,
      title: massEmailFormObject.title,
      parentsAuthCheck: massEmailFormObject.parentsAuthCheck,
      body: massEmailFormObject.body,
      plain: massEmailFormObject.plain
    },
    success: function (response) {
      console.log(response);
      if (response.result == 0) {
        alert("IT");
      } else {
        toggleSpinner();
        showSwal('success', '')
        $("#newEmailModal").modal("hide");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function saveMessage(messageFormObject) {
  toggleSpinner();
  $.ajax({
    url: "ajax_php/a.saveMessage.php",
    type: "POST",
    dataType: "json",
    data: messageFormObject,
    success: function (response) {
      console.log(response);
      if (response.result == 0) {
        toggleSpinner();
        alert("IT");
      } else {
        toggleSpinner();
        showSwal('success', '')
        $("#createMsgModal").modal("hide");
        $("#datatables-msgList tbody > tr").remove();
        $(".custom-filter").remove();
        init();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function getMessageList() {
  var eData = [];

  $.ajax({
    url: "ajax_php/a.getMessageList.php",
    type: "POST",
    dataType: "json",
    async: false,
    success: function (response) {
      console.log(response);
      globalMsgList = response;
      var today = new Date();
      for (let i = 0; i < response.length; i++) {
        var status = "";
        var statusCode = "";
        var pDate = "";
        var eDate = "";
        var toFrontPage = "";
        if (response[i].Expiry === "1" && today > new Date(response[i].ExpiryDate)) {
          status = "";
          statusCode = "0";
        } else {
          status = '<i class="material-icons-outlined">notifications_active</i>';
          statusCode = "1";
        }

        pDate = response[i].PublishDate.substring(0, 16);
        if (response[i].Expiry === "1") {
          eDate = response[i].ExpiryDate.substring(0, 16);
        } else {
          eDate = "n/a";
        }

        if (response[i].ToFrontPage === "1") {
          toFrontPage = '<i class="material-icons-outlined">add_to_home_screen</i>';
        } else {
          toFrontPage = "";
        }

        var atag = '<a href="#listModal" data-toggle="modal" data-id="' + response[i].MessageID + '" data-target="#listModal" class="msgLink">' + response[i].Subject + "</a>";

        eData.push([
          atag, response[i].FromStaffName,
          pDate,
          toFrontPage,
          response[i].ToFrontPage,
          status,
          statusCode,
          eDate,
          response[i].MessageID,
          response[i].Body,
          response[i].SemesterName,
          response[i].FromStaffID,
          response[i].FromStaffName
        ]);
      }

      table = $("#datatables-msgList").DataTable({
        data: eData,
        deferRender: true,
        bDestroy: true,
        autoWidth: false,
        responsive: true,
        order: [
          [2, "desc"]
        ],
        pagingType: "simple_numbers",
        lengthMenu: [
          [
            10, 25, 50, -1
          ],
          [
            10, 25, 50, "All"
          ]
        ],
        language: {
          paginate: {
            next: '<i class="material-icons">keyboard_arrow_right</i>',
            previous: '<i class="material-icons">keyboard_arrow_left</i>'
          }
        },
        dom: '<"row"<"col-md-12 "f l>>t<"row"<"col-md-6"i><"col-md-6"p>>',
        columnDefs: [
          {
            targets: 0,
            width: "49%"
          }, {
            targets: 1,
            width: "15%"
          }, {
            width: "10%",
            targets: 2,
            className: "text-center"
          }, {
            width: "8%",
            targets: 3,
            className: "text-center"
          }, {
            visible: false,
            targets: 4
          }, {
            width: "8%",
            targets: 5,
            className: "text-center"
          }, {
            visible: false,
            targets: 6
          }, {
            width: "10%",
            targets: 7,
            className: "text-center"
          }, {
            visible: false,
            targets: 8
          }, {
            visible: false,
            targets: 9
          }, {
            visible: false,
            targets: 10
          }, {
            visible: false,
            targets: 11
          }, {
            visible: false,
            targets: 12
          }
        ]
      });
      var select_staff = $('<select class="form-control custom-form displayInlineBlock maxwidth200 custom-filter" id="msgList-sender" />').appendTo(".msgList-filter-sender");
      createFilter(table, select_staff);
      var select_status = $('#msgList-status');
      table.columns().every(function (index) {
        if (index == 11) {
          var that = this;

          select_staff.on("change", function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());

            that.search(
              val
                ? "^" + val + "$"
                : "",
              true,
              false).draw();
          });
        } else if (index == 6) {
          var that = this;

          select_status.on("change", function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());

            that.search(
              val
                ? "^" + val + "$"
                : "",
              true,
              false).draw();
          });
        }
      });

      table.column(4).every(function () {
        var that = this;

        // Create the select list and search operation
        var select = $('<select class="form-control custom-form displayInlineBlock maxwidth150 custom-filter" />').appendTo(".msgList-filter-front").on("change", function () {
          that.search($(this).val()).draw();
        });

        // Get the search data for the first column and add to the select list
        select.append($('<option value="">All</option>'));

        var f;
        var nf;
        this.cache("search").sort().unique().each(function (d) {
          if (d === "0") {
            // select.append($('<option value="' + d + '">Not Front</option>'));
            nf = $('<option value="' + d + '">Not Front</option>')
          } else {
            // select.append($('<option value="' + d + '">Front</option>'));
            f = $('<option value="' + d + '">Front</option>')
          }
        });
        select.append(f);
        select.append(nf);
      });


      table.column(10).every(function () {
        var that = this;

        // Create the select list and search operation
        var select = $('<select class="form-control custom-form displayInlineBlock maxwidth200 custom-filter" id="msgList-term" />').appendTo(".msgList-filter-term").on("change", function () {
          that.search($(this).val()).draw();
        });

        // Get the search data for the first column and add to the select list
        select.append($('<option value="">All</option>'));

        this.cache("search").sort().unique().each(function (d) {
          select.append($('<option value="' + d + '">' + d + "</option>"));
        });
      });
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function getUserFullName(id) {
  var name;
  $.ajax({
    url: "ajax_php/a.getUserFullName.php",
    type: "POST",
    dataType: "json",
    async: false,
    data: {
      id: id
    },
    success: function (response) {
      if (response.result == 0) {
        console.log("contact IT");
      } else {
        name = response[0].FullName;
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
  return name;
}

function updateMessage(messageFormObject) {
  toggleSpinner();
  $.ajax({
    url: "ajax_php/a.updateMessage.php",
    type: "POST",
    dataType: "json",
    data: messageFormObject,
    success: function (response) {
      if (response.result == 0) {
        console.log("contact IT");
      } else {
        toggleSpinner();
        showSwal("success", "");
        $("#listModal").modal("hide");
        $("#datatables-msgList tbody > tr").remove();
        $(".custom-filter").remove();
        init();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function createFilter(table, select) {
  var sVal = [];
  var rVal = [];
  for (var i = 11; i < 13; i++) {
    table.column(i).cache("search").unique().each(function (d) {
      if (i == 11) {
        sVal.push(d);
      } else {
        rVal.push(d);
      }
    });
  }
  select.append($('<option value="">All</option>'));
  for (var j = 0; j < sVal.length; j++) {
    select.append($('<option value="' + sVal[j] + '">' + rVal[j] + "</option>"));
  }
}

function showCurrentTerm() {
  var tr;
  $.ajax({
    url: "ajax_php/a.currentterm.php",
    type: "POST",
    dataType: "json",
    success: function (response) {
      globalSemesterList = response;
      if (response.result == 0) {
        console.log("IT");
      } else {
        // console.log(response);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function getParentsEmailList() {
  $.ajax({
    url: "ajax_php/a.getParentsEmailList.php",
    type: "POST",
    dataType: "json",
    success: function (response) {
      if (response.result == 0) {
        console.log("IT");
      } else {
        globalParentsEmailList = response;
        $('.verifiedMail').html(globalParentsEmailList.length);
        $('.unverifiedMail').html("0");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}

function deleteMessage(id) {
  swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger',
    confirmButtonText: 'Yes, remove it',
    buttonsStyling: false
  }).then(function () {
    toggleSpinner();
    $.ajax({
      url: "ajax_php/a.updateMessageStatusCode.php",
      type: "POST",
      dataType: "json",
      data: {
        id: id,
        status: 'removed_by_user'
      },
      success: function (response) {
        toggleSpinner();
        if (response.result == 0) {
          console.log("IT");
        } else {
          swal({
            title: 'Removed!',
            text: 'Message has been removed.',
            type: 'success',
            confirmButtonClass: "btn btn-success",
            buttonsStyling: false
          })
          $("#listModal").modal("hide");
          $("#datatables-msgList tbody > tr").remove();
          $(".custom-filter").remove();
          init();
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert("ajax error : " + textStatus + "\n" + errorThrown);
      }
    });
  }).catch(swal.noop)




}
