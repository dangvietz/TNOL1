Dashmix.helpersOnLoad(["js-flatpickr", "jq-datepicker", "jq-select2"]);

Dashmix.onLoad(() =>
  class {
    static initValidation() {
      Dashmix.helpers("jq-validation"),
        jQuery(".form-add-subject").validate({
          rules: {
            makhoa: {
              required: !0,
              digits: true,
            },
            tenkhoa: {
              required: !0,
            },
          },
          messages: {
            makhoa: {
              required: "Vui lòng nhập mã khoa",
              digits: "Mã khoa phải là các ký tự số",
            },
            tenkhoa: {
              required: "Vui lòng cung cấp tên khoa",
            },
          },
        });
    }

    static init() {
      this.initValidation();
    }
  }.init()
);

function showData(subjects) {
  let html = "";
  subjects.forEach((subject) => {
    html += `<tr tid="${subject.makhoa}">
              <td class="text-center fs-sm"><strong>${subject.makhoa}</strong></td>
              <td>${subject.tenkhoa}</td>
              <td class="text-center col-action">
                  <a data-role="chuong" data-action="view" class="btn btn-sm btn-alt-secondary subject-info" data-bs-toggle="modal" data-bs-target="#modal-class" href="javascript:void(0)"
                      data-bs-toggle="tooltip" aria-label="Thêm lớp" data-bs-original-title="Chi tiết lớp" data-id="${subject.makhoa}">
                      <i class="fa fa-circle-info"></i>
                  </a>
                  <a data-role="khoa" data-action="update" class="btn btn-sm btn-alt-secondary btn-edit-subject" href="javascript:void(0)"
                      data-bs-toggle="tooltip" aria-label="Sửa khoa" data-bs-original-title="Sửa khoa" data-id="${subject.makhoa}">
                      <i class="fa fa-fw fa-pencil"></i>
                  </a>
                  <a data-role="khoa" data-action="delete" class="btn btn-sm btn-alt-secondary btn-delete-subject" href="javascript:void(0)"
                      data-bs-toggle="tooltip" aria-label="Xoá khoa" data-bs-original-title="Xoá khoa" data-id="${subject.makhoa}">
                      <i class="fa fa-fw fa-times"></i>
                  </a>
              </td>
          </tr>`;
  });
  $("#list-subject").html(html);
  $('[data-bs-toggle="tooltip"]').tooltip();
}

// function loadData() {
//   $.ajax({
//     type: "get",
//     url: "./faculty/getAllSubject",
//     dataType: "json",
//     success: function (response) {
//       showData(response);
//     },
//   });
// }

// loadData();

$(document).ready(function () {
  $("[data-bs-target='#modal-add-subject']").click(function (e) {
    e.preventDefault();
    $(".update-subject-element").hide();
    $(".add-subject-element").show();
  });

  function checkTonTai(makhoa) {
    let check = true;
    $.ajax({
      type: "post",
      url: "./faculty/checkFaculty",
      data: {
        makhoa: makhoa,
      },
      async: false,
      dataType: "json",
      success: function (response) {
        if (response.length !== 0) {
          Dashmix.helpers("jq-notify", {
            type: "danger",
            icon: "fa fa-times me-1",
            message: `Mã khoa đã tồn tại!`,
          });
          check = false;
        }
      },
    });
  }

  function checkTenLop(tenlop) {
    let check = true;
    $.ajax({
      type: "post",
      url: "./faculty/checkFacultyName",
      data: {
        tenlop: tenlop,
      },
      async: false,
      dataType: "json",
      success: function (response) {
        if (response.length !== 0) {
          Dashmix.helpers("jq-notify", {
            type: "danger",
            icon: "fa fa-times me-1",
            message: `Tên lớp đã tồn tại!`,
          });
          check = false;
        }
      },
    });
    return check;
  }

  $("#add_subject").on("click", function () {
    let makhoa = $("#makhoa").val();
    if ($(".form-add-subject").valid() && !checkTonTai(makhoa)) {
      $.ajax({
        type: "post",
        url: "./faculty/add",
        data: {
          makhoa: makhoa,
          tenkhoa: $("#tenkhoa").val(),
        },
        success: function (response) {
          if (response) {
            Dashmix.helpers("jq-notify", {
              type: "success",
              icon: "fa fa-check me-1",
              message: "Thêm khoa thành công!",
            });
            $("#modal-add-subject").modal("hide");
            mainPagePagination.getPagination(
              mainPagePagination.option,
              mainPagePagination.valuePage.curPage
            );
          } else {
            Dashmix.helpers("jq-notify", {
              type: "danger",
              icon: "fa fa-times me-1",
              message: "Thêm khoa không thành công!",
            });
          }
        },
      });
    }
  });

  $(document).on("click", ".btn-edit-subject", function () {
    $(".update-subject-element").show();
    $(".add-subject-element").hide();
    let makhoa = $(this).data("id");
    $.ajax({
      type: "post",
      url: "./faculty/getDetail",
      data: {
        makhoa: makhoa,
      },
      dataType: "json",
      success: function (response) {
        if (response) {
          $("#makhoa").val(response.makhoa),
            $("#tenkhoa").val(response.tenkhoa),
            $("#modal-add-subject").modal("show"),
            $("#update_subject").data("id", response.makhoa);
        }
      },
    });
  });

  // Đóng modal thì reset form
  $("#modal-add-subject").on("hidden.bs.modal", function () {
    $("#makhoa").val(""),
      $("#tenkhoa").val(""),
      $("#sotinchi").val(""),
      $("#sotiet_lt").val(""),
      $("#sotiet_th").val(""),
      $("#update_subject").data("id", "");
  });

  $("#update_subject").click(function (e) {
    e.preventDefault();
    let makhoa = $(this).data("id");
    if ($(".form-add-subject").valid()) {
      $.ajax({
        type: "post",
        url: "./faculty/update",
        data: {
          id: makhoa,
          makhoa: $("#makhoa").val(),
          tenkhoa: $("#tenkhoa").val(),
        },
        success: function (response) {
          if (response) {
            $("#modal-add-subject").modal("hide");
            Dashmix.helpers("jq-notify", {
              type: "success",
              icon: "fa fa-check me-1",
              message: "Cập nhật khoa thành công!",
            });
            mainPagePagination.getPagination(
              mainPagePagination.option,
              mainPagePagination.valuePage.curPage
            );
          } else {
            Dashmix.helpers("jq-notify", {
              type: "danger",
              icon: "fa fa-times me-1",
              message: "Cập nhật khoa không thành công!",
            });
          }
        },
      });
    }
  });

  $(document).on("click", ".btn-delete-subject", function () {
    let trid = $(this).data("id");
    let e = Swal.mixin({
      buttonsStyling: !1,
      target: "#page-container",
      customClass: {
        confirmButton: "btn btn-success m-1",
        cancelButton: "btn btn-danger m-1",
        input: "form-control",
      },
    });

    e.fire({
      title: "Are you sure?",
      text: "Bạn có chắc chắn muốn xoá nhóm khoa?",
      icon: "warning",
      showCancelButton: !0,
      customClass: {
        confirmButton: "btn btn-danger m-1",
        cancelButton: "btn btn-secondary m-1",
      },
      confirmButtonText: "Vâng, tôi chắc chắn!",
      html: !1,
      preConfirm: (e) =>
        new Promise((e) => {
          setTimeout(() => {
            e();
          }, 50);
        }),
    }).then((t) => {
      if (t.value == true) {
        $.ajax({
          type: "post",
          url: "./faculty/delete",
          data: {
            makhoa: trid,
          },
          success: function (response) {
            if (response) {
              e.fire("Deleted!", "Xóa khoa thành công!", "success");
              mainPagePagination.getPagination(
                mainPagePagination.option,
                mainPagePagination.valuePage.curPage
              );
            } else {
              e.fire("Lỗi !", "Xoá khoa không thành công !)", "error");
            }
          },
        });
      }
    });
  });

  //chapter
  $(document).on("click", ".subject-info", function () {
    var id = $(this).data("id");
    $("#makhoa_lop").val(id);
    showClass(id);
  });

  function resetFormChapter() {
    $("#collapseChapter").collapse("hide");
    $("#name_class").val("");
  }

  $("#modal-class").on("hidden.bs.modal", function () {
    resetFormChapter();
  });

  function showClass(makhoa) {
    $.ajax({
      type: "post",
      url: "./faculty/getAllClass",
      data: {
        makhoa: makhoa,
      },
      dataType: "json",
      success: function (response) {
        let html = "";
        if (response.length > 0) {
          response.forEach((chapter, index) => {
            html += `<tr>
                        <td class="text-center fs-sm"><strong>${
                          index + 1
                        }</strong></td>
                        <td>${chapter["tenlop"]}</td>
                        <td class="text-center col-action">
                            <a data-role="chuong" data-action="update" class="btn btn-sm btn-alt-secondary chapter-edit"
                                data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit" data-id="${
                                  chapter["malop"]
                                }">
                                <i class="fa fa-fw fa-pencil"></i>
                            </a>
                            <a data-role="chuong" data-action="delete" class="btn btn-sm btn-alt-secondary chapter-delete" href="javascript:void(0)"
                                data-bs-toggle="tooltip" aria-label="Delete"
                                data-bs-original-title="Delete" data-id="${
                                  chapter["malop"]
                                }">
                                <i class="fa fa-fw fa-times"></i>
                            </a>
                        </td>
                    </tr>`;
          });
        } else {
          html += `<tr><td class="text-center fs-sm" colspan="3">
                    <img style="width:180px" src="./public/media/svg/empty_data.png" alt=""/>
                    <p class="text-center mt-3">Không có dữ liệu</p>
                    </td>
                    </tr>`;
        }
        $("#showChapper").html(html);
      },
    });
  }

  $("#btn-add-class").click(function () {
    $("#add-class").show();
    $("#edit-class").hide();
    $("#name_class").val("");
  });

  $("#add-class").on("click", function (e) {
    e.preventDefault();
    let makhoa = $("#makhoa_lop").val();
    if ($("#name_class").val() == "") {
      Dashmix.helpers("jq-notify", {
        type: "danger",
        icon: "fa fa-times me-1",
        message: "Tên lớp không để trống!",
      });
    } else {
      if (checkTenLop($("#name_class").val()))
        $.ajax({
          type: "post",
          url: "./faculty/addClass",
          data: {
            makhoa: makhoa,
            tenkhoa: $("#name_class").val(),
          },
          success: function (response) {
            if (response) {
              Dashmix.helpers("jq-notify", {
                type: "success",
                icon: "fa fa-times me-1",
                message: "Thêm lớp thành công",
              });
              resetFormChapter();
              showClass(makhoa);
            }
          },
        });
    }
  });

  $(".close-class").click(function (e) {
    e.preventDefault();
    $("#collapseChapter").collapse("hide");
  });

  $(document).on("click", ".chapter-delete", function () {
    let malop = $(this).data("id");
    $.ajax({
      type: "post",
      url: "./faculty/classDelete",
      data: {
        malop: malop,
      },
      success: function (response) {
        if (response) {
          Dashmix.helpers("jq-notify", {
            type: "success",
            icon: "fa fa-check me-1",
            message: "Xoá lớp thành công!",
          });
          showClass($("#makhoa_lop").val());
        } else {
          Dashmix.helpers("jq-notify", {
            type: "danger",
            icon: "fa fa-times me-1",
            message: "Xoá lớp không thành công!",
          });
        }
      },
    });
  });

  $(document).on("click", ".chapter-edit", function () {
    $("#add-class").hide();
    $("#edit-class").show();
    let id = $(this).data("id");
    $("#malop").val(id);
    $("#collapseChapter").collapse("show");
    let name = $(this).closest("td").closest("tr").children().eq(1).text();
    $("#name_class").val(name);
  });

  $("#edit-class").on("click", function (e) {
    e.preventDefault();
    $.ajax({
      type: "post",
      url: "./faculty/updateClass",
      data: {
        malop: $("#malop").val(),
        tenlop: $("#name_class").val(),
      },
      success: function (response) {
        if (response) {
          showClass($("#makhoa_lop").val());
          resetFormChapter();
          Dashmix.helpers("jq-notify", {
            type: "success",
            icon: "fa fa-check me-1",
            message: "Cập nhật lớp thành công!",
          });
        } else {
          Dashmix.helpers("jq-notify", {
            type: "danger",
            icon: "fa fa-times me-1",
            message: "Cập nhật lớp không thành công!",
          });
        }
      },
    });
  });
});

// Pagination
const mainPagePagination = new Pagination();
mainPagePagination.option.controller = "faculty";
mainPagePagination.option.model = "KhoaModel";
mainPagePagination.option.limit = 10;
mainPagePagination.getPagination(
  mainPagePagination.option,
  mainPagePagination.valuePage.curPage
);
