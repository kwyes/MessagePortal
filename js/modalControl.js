$(document).ready(function () {
  $('#publishAt').on('dp.change', function (e) {
    var pDate = $('#publishAt').val();
    var dDate = $("#disp-until").val();

    if (new Date(pDate).getTime() > new Date(dDate).getTime()) {
      var newdDate = moment(new Date(new Date(pDate).getTime() + 7 * 24 * 60 * 60 * 1000)).format(
        'YYYY-MM-DD hh:mm A');
      $('#disp-until').val(newdDate);
    }
  })

  $(".radio-expiry input").click(function (event) {
    var target = event.target;
    var val = $(target).val();
    var pdate = $('#publishAt').val();

    if (val == 1) {
      $(".displayUntil").css("display", "inline");
      var nextweek = moment(new Date().getTime() + 7 * 24 * 60 * 60 * 1000).format('YYYY-MM-DD');
      var newday = nextweek + " 11:59 PM"
      $("#disp-until").val(moment(new Date(newday)).format('YYYY-MM-DD hh:mm A'));
      $("#disp-until").prop("required", true);
    } else {
      $("#disp-until").val("");
      $(".displayUntil").css("display", "none");
    }
  });

  $(".radio-publish input").click(function (event) {
    var target = event.target;
    var val = $(target).val();

    if (val == 1) {
      $('.publishWrapper').hide();
      $('#publishAt').val(moment(new Date).format('YYYY-MM-DD hh:mm A'));
      $('#msg-save-btn').html('Save and Publish');
      $('#publishAt').prop("required", false);
    } else {
      $('.publishWrapper').show();
      var tomorrow = moment(new Date(new Date().getTime() + 24 * 60 * 60 * 1000)).format(
        'YYYY-MM-DD');
      $('#publishAt').val(moment(tomorrow).format('YYYY-MM-DD hh:mm A'));
      $('#msg-save-btn').html('Save');
      $('#publishAt').prop("required", true);
    }
  });


  $("#radioY-label input[value='1']").click(function () {
    $(".requireIcon").css("display", "inline");
    // $("#msg-body").prop("required", true);
  });

  $(".checkAll").click(function (event) {
    var target = event.target;
    $(target).toggleClass("allChecked")
    if ($(target).hasClass("allChecked")) {
      $(".publishTo").prop("checked", true);
    } else {
      $(".publishTo").prop("checked", false);
    }
  })

  $(".publishTo").click(function () {
    if ($(".checkAll").hasClass("allChecked")) {
      $(".checkAll").toggleClass("allChecked");
      $(".checkAll").prop("checked", false);
    }
  })
});

$(document).on("click", ".stuInfLink", function (event) {
  var target = $(event.target);
  if (target.hasClass("actTitleLink")) {
    target.attr({ href: "#stuInfModal", "data-target": "#stuInfModal" });
  }
});

$(document).on("click", ".msgLink", function (event) {
  var divEditor = textboxio.replace('#edit-body');
  var id = $(this).attr("data-id");
  for (let i = 0; i < globalMsgList.length; i++) {
    if (globalMsgList[i].MessageID == id) {
      var pdate = globalMsgList[i].PublishDate.substring(0, 16);
      var modifieddate = globalMsgList[i].ModifyDate.substring(0, 16);
      var createddate = globalMsgList[i].CreateDate.substring(0, 16);
      $(".msgId").val(globalMsgList[i].MessageID);
      $(".msgCategory").val(globalMsgList[i].MsgCategory).change();
      $(".from").html(globalMsgList[i].FromStaffName);
      $(".subject").val(globalMsgList[i].Subject);
      // $(".body").val(globalMsgList[i].Body);
      divEditor.content.set(globalMsgList[i].Body);
      $(".pdate").html(moment(new Date(pdate)).format('YYYY-MM-DD hh:mm A'));
      $(".publishto").html(globalMsgList[i].ToType);
      $("input[name='frontpage'][value='" + globalMsgList[i].ToFrontPage + "']").prop("checked", true);
      $("input[name='expires'][value='" + globalMsgList[i].Expiry + "']").prop("checked", true);
      if (globalMsgList[i].Expiry == "0") {
        $(".edate-input").css("display", "none");
      } else {
        $(".edate-input").css("display", "flex");
        var edate = globalMsgList[i].ExpiryDate.substring(0, 16);
        $(".edate").val(moment(new Date(edate)).format('YYYY-MM-DD hh:mm A'));
        $(".edate").prop("required", true);
      }

      $(".modifieddate").html(modifieddate + " by " + getUserFullName(globalMsgList[i].ModifyUserID));
      $(".createddate").html(createddate + " by " + getUserFullName(globalMsgList[i].CreateUserID));
    }
  }
});

$(document).on("click", "#createMsg", function (event) {
  var divEditor = textboxio.replace('#msg-body');
  divEditor.content.set('');

  $("#msg-category").val("announcement_school").change();
  $("#msg-title").val("");
  $("#msg-body").val("");
  $("input[name='publishCheck']").prop("checked", false);
  $("input[name='pmCheck']").prop("checked", true);
  $("input[name='pwCheck']").prop("checked", false);
  $("input[name='smCheck']").prop("checked", false);
  $("input[name='swCheck']").prop("checked", false);
  $("input[name='post'][value='0']").prop("checked", false);
  $("input[name='post'][value='1']").prop("checked", true);
  $("input[name='publish'][value='0']").prop("checked", false);
  $("input[name='publish'][value='1']").prop("checked", true);
  $("input[name='expiry'][value='0']").prop("checked", false);
  $("input[name='expiry'][value='1']").prop("checked", true);
  $(".publishWrapper").css("display", "none");
  $(".displayUntil").css("display", "flex");
  // var tomorrow = moment(new Date(new Date().getTime() + 24 * 60 * 60 * 1000)).format(
  //   'YYYY-MM-DD');
  $('#publishAt').val(moment(new Date()).format('YYYY-MM-DD hh:mm A'));
  var nextweek = moment(new Date().getTime() + 7 * 24 * 60 * 60 * 1000).format('YYYY-MM-DD');
  var newday = nextweek + " 11:59 PM"
  $("#disp-until").val(moment(new Date(newday)).format('YYYY-MM-DD hh:mm A'));
});


$("#listModal").on("hidden.bs.modal", function () {
  clearFormValidation("#listMdlForm");
  clearForm("#listMdlForm");
});

$(document).on("click", "#listMdl-close-btn", function (event) {
  $("#listModal").modal("hide");
});

$(document).on("click", "#listMdl-save-btn", function (event) {
  setFormValidation("#listMdlForm");
  if ($("#listMdlForm").valid()) {
    var messageForm = $("#listMdlForm").serializeArray();
    var messageFormObject = {};
    $.each(messageForm, function (i, v) {
      messageFormObject[v.name] = v.value;
    });
    updateMessage(messageFormObject);
  }
});

$("#createMsgModal").on("hidden.bs.modal", function () {
  clearFormValidation("#messageForm");
  clearForm("#messageForm");
  $(".task1").css("display", "block");
  $(".task2").css("display", "none");
});

$(document).on("click", "#msg-cancel-btn", function (event) {
  $("#createMsgModal").modal("hide");
});

$(document).on("click", "#msg-next-btn", function (event) {
  setFormValidation("#messageForm");
  if ($("#messageForm").valid()) {
    $('.task1').css('display', 'none');
    $('.task2').css('display', 'block');
    $("#disp-until").prop("required", true);
  }
})

$(document).on("click", "#msg-back-btn", function (event) {
  $('.task1').css('display', 'block');
  $('.task2').css('display', 'none');
})

$(document).on("click", "#msg-save-btn", function (event) {
  setFormValidation("#messageForm");
  if ($("#messageForm").valid()) {
    var messageForm = $("#messageForm").serializeArray();
    var editors = textboxio.get("#msg-body");
    var editor = editors[0];
    var htmlbody = editor.content.get();
    var body = strip(htmlbody);
    messageForm.push(
      {
        name: "body",
        value: body
      },
      {
        name: "plain",
        value: htmlbody
      }
    );
    var messageFormObject = {};
    $.each(messageForm, function (i, v) {
      messageFormObject[v.name] = v.value;
    });

    if (messageFormObject.publishAt == "") {
      var tomorrow = moment(new Date(new Date().getTime() + 24 * 60 * 60 * 1000)).format(
        'YYYY-MM-DD');
      messageFormObject.publishAt = moment(tomorrow).format('YYYY-MM-DD hh:mm A');
    }

    if (messageFormObject.expiryDate == "") {
      var nextweek = moment(new Date().getTime() + 7 * 24 * 60 * 60 * 1000).format('YYYY-MM-DD');
      var newday = nextweek + " 11:59 PM";
      messageFormObject.publishAt = moment(new Date(newday)).format('YYYY-MM-DD hh:mm A');
    }

    messageFormObject['msgType'] = 'app_notify';
    messageFormObject['msgStatusCode'] = 'sent';
    messageFormObject['fromType'] = 'int_user_staff_admin';
    messageFormObject['fromSystem'] = 'sas_admin';
    messageFormObject['fromDept'] = 'administration_school_mgmt';
    messageFormObject['toType'] = 'ext_parent_mobile';
    messageFormObject['toScope'] = 'everyone';

    console.log(messageFormObject)
    $("form .checkbox-credit").each(function () {
      messageFormObject[this.name] = this.checked;
    });
    var pdate = messageFormObject.publishAt;
    var ddate = messageFormObject.expiryDate;

    if (new Date(pdate).getTime() > new Date(ddate).getTime()) {
      showSwal('error', '"Display until" is invalid.')
    } else if (body == '') {
      swal({
        title: 'There\'s no message body.',
        text: "Do you want to publish without it?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Yes, I do.',
        buttonsStyling: false
      })
        .then(function () {
          saveMessage(messageFormObject);
        })
        .catch(swal.noop)
    } else {
      saveMessage(messageFormObject);
    }
  }
});

$("#newEmailModal").on("hidden.bs.modal", function () {
  clearFormValidation("#massEmailForm");
  clearForm("#massEmailForm");
  $(".task1").css("display", "block");
  $(".task2").css("display", "none");
});

$(document).on("click", "#newEmail", function (event) {
  var divEditor = textboxio.replace('#massEmail-body');
  divEditor.content.set('');

  $("input[name='parentsAuthCheck']").prop("checked", false);
});

$(document).on("click", "#massEmail-cancel-btn", function (event) {
  $("#newEmailModal").modal("hide");
});

$(document).on("click", "#massEmail-next-btn", function (event) {
  setFormValidation("#massEmailForm");
  if ($("#massEmailForm").valid()) {
    var massEmailForm = $("#massEmailForm").serializeArray();
    var editors = textboxio.get("#massEmail-body");
    var editor = editors[0];
    var htmlbody = editor.content.get();
    var body = strip(htmlbody);
    massEmailForm.push(
      {
        name: "body",
        value: body
      },
      {
        name: "plain",
        value: htmlbody
      }
    );

    $(".checkbox-parentsAuth").each(function () {
      massEmailForm.push({ name: this.name, value: this.checked });
    });

    $.each(massEmailForm, function (i, v) {
      massEmailFormObject[v.name] = v.value;
    });

    getParentsEmailList();
    console.log(globalParentsEmailList);
    $('.task1').css('display', 'none');
    $('.task2').css('display', 'block');
  }
})

$(document).on("click", "#massEmail-back-btn", function (event) {
  $('.task1').css('display', 'block');
  $('.task2').css('display', 'none');
})

$(document).on("click", "#massEmail-send-btn", function (event) {


  // console.log(massEmailFormObject)
  sendMessage(globalParentsEmailList, massEmailFormObject);
  // sendMessage(arr, massEmailFormObject);
});

$(document).on("click", ".checkbox-parentsAuth", function (event) {
  if ($(this).prop("checked") == true) {
    $('.massEmail-bodyWrapper').css('display', 'none');
  } else {
    $('.massEmail-bodyWrapper').css('display', 'flex');
  }
});

$(document).on("click", "#listMdl-remove-btn", function (event) {
  var id = $(".msgId").val();
  deleteMessage(id);
})
