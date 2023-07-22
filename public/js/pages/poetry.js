Dashmix.helpersOnLoad(["js-flatpickr", "jq-datepicker"]);

Dashmix.onLoad(() =>
  class {
    static initValidation() {
      Dashmix.helpers("jq-validation"),
        jQuery(".form-add-poetry").validate({
          rules: {
            tencathi: {
              required: !0,
            },
            dethi: {
              required: !0,
            },
            cathi: {
              required: !0,
            },
            ngaythi: {
              required: !0,
            },
            loaide: {
              required: !0,
            },
          },
          messages: {
            tencathi: {
              required: "Vui lòng điền tên ca thi",
            },
            dethi: {
              required: "Vui lòng chọn ca thi",
            },
            cathi: {
              required: "Vui lòng chọn ca thi",
            },
            ngaythi: {
              required: "Vui lòng chọn ngày thi",
            },
            loaide: {
              required: "Vui lòng chọn loại ca thi",
            },
          },
        });
    }
    static init() {
      this.initValidation();
    }
  }.init()
);

function dateIsValid(date) {
  return !Number.isNaN(new Date(date).getTime());
}

$("#btn-and").click(function (e) {
  e.preventDefault();
  $("#btn-add-poetry").show();
  $("#btn-update-poetry").hide();
  clearInputFields();
});


function loadData(query,filter) {
  $.ajax({
    type: "post",
    url: "./poetry/getPoetryAll",
    data: {
      query: query,
      filter: filter
    },
    dataType: "json",
    success: function (response) {
      showListTest(response);
    },
  });
}

var filter = 3;
loadData($("#search-input").val(),filter);


$(".filtered-by-state").click(function (e) {
  e.preventDefault();
  $(".btn-filtered-by-state").text($(this).text());
  const state = $(this).data("value");
  filter = state;
  let search = $("#search-input").val();
  loadData(search,filter);
});

$("#search-input").on("input",function (e) { 
  e.preventDefault();
  loadData($("#search-input").val(),filter);
});

function showListTest(tests) {
  const format = new Intl.DateTimeFormat(navigator.language, {
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
    hour: "2-digit",
    minute: "2-digit",
  });
  html = ``;
  if (tests.length == 0) {
    html += `<p class="text-center">Không có dữ liệu</p>`;
    $(".pagination").hide();
  } else {
    tests.forEach((test) => {
      let htmlTestState = ``;
      const open = new Date(test.thoigianbatdau);
      const close = new Date(test.thoigianketthuc);
      let strOpenTime = "",
        strCloseTime = "";
      if (dateIsValid(test.thoigianbatdau)) {
        strOpenTime = format.format(open);
      }
      if (dateIsValid(test.thoigianketthuc)) {
        strCloseTime = format.format(close);
      }
      const state = {};
      const now = Date.now();
      if (now < +open) {
        state.color = "secondary";
        state.text = "Chưa mở";
      } else if (now >= +open && now <= +close) {
        state.color = "primary";
        state.text = "Đang mở";
      } else {
        state.color = "danger";
        state.text = "Đã đóng";
      }
      htmlTestState += `<button class="btn btn-sm btn-alt-${state.color} rounded-pill px-3 me-1 my-1" disabled>${state.text}</button>`;
      html += `<div class="block block-rounded block-fx-pop mb-2">
                <div class="block-content block-content-full border-start border-3 border-${
                  state.color
                }">
                    <div class="d-md-flex justify-content-md-between align-items-md-center">
                        <div class="p-1 p-md-3">
                            <h3 class="h4 fw-bold mb-3">
                                <a href="#" class="text-dark link-fx">${
                                  test.tencathi
                                }</a>
                            </h3>
                            <p class="fs-sm text-muted mb-2">
                                <i class="fa fa-layer-group me-1"></i></i> Tên đề <strong data-bs-toggle="tooltip" data-bs-animation="true" data-bs-placement="top" style="cursor:pointer">${
                                  test.tende
                                }</strong>
                            </p>
                            <p class="fs-sm text-muted mb-2">
                                <i class="fa fa-layer-group me-1"></i></i> Ngày thi <strong data-bs-toggle="tooltip" data-bs-animation="true" data-bs-placement="top" style="cursor:pointer">${
                                  test.ngaythi
                                }</strong>
                            </p>
                            <p class="fs-sm text-muted mb-2">
                                <i class="fa fa-layer-group me-1"></i></i> Thời gian làm bài <strong data-bs-toggle="tooltip" data-bs-animation="true" data-bs-placement="top" style="cursor:pointer">${
                                  test.khunggio
                                }</strong>
                            </p>
                            <p class="fs-sm text-muted mb-2">
                                <i class="fa fa-layer-group me-1"></i></i> Loại ca thi <strong data-bs-toggle="tooltip" data-bs-animation="true" data-bs-placement="top" style="cursor:pointer">${
                                  test.loaikythi == "giua_ky"
                                    ? "Giữa kỳ"
                                    : "Cuối kỳ"
                                }</strong>
                            </p>
                        </div>
                        <div class="p-1 p-md-3">
                            ${htmlTestState}
                            <a class="btn btn-sm btn-alt-success rounded-pill px-3 me-1 my-1 btn-detail"  href="javascript:void(0)"data-id="${
                              test.macathi
                            }">
                                <i class="fa fa-eye opacity-50 me-1"></i> Xem chi tiết
                            </a>
                            <a data-role="dethi" data-action="update" class="btn btn-sm btn-alt-primary rounded-pill px-3 me-1 my-1" href="./test/update/${
                              test.made
                            }">
                                <i class="fa fa-wrench opacity-50 me-1"></i> Chỉnh sửa đề
                            </a>
                            <a data-role="dethi" data-action="delete" class="btn btn-sm btn-alt-danger rounded-pill px-3 my-1 btn-delete" href="javascript:void(0)" data-id="${
                              test.macathi
                            }">
                                <i class="fa fa-times opacity-50 me-1"></i> Xoá ca thi
                            </a>
                        </div>
                    </div>
                </div>
            </div>`;
    });
  }
  $("#list-test").html(html);
  $('[data-bs-toggle="tooltip"]').tooltip();
}

$(document).ready(function () {
  $("#dethi").select2({
    dropdownParent: $("#modal-add-poetry"),
  });

  $.get(
    "./poetry/getAllTest",
    function (data) {
      let html = `<option></option>`;
      data.forEach((item) => {
        html += `<option value="${item.made}">${item.tende}</option>`;
      });
      $("#dethi").html(html);
    },
    "json"
  );

  let e = Swal.mixin({
    buttonsStyling: !1,
    target: "#page-container",
    customClass: {
      confirmButton: "btn btn-success m-1",
      cancelButton: "btn btn-danger m-1",
      input: "form-control",
    },
  });

  $(document).on("click", ".btn-delete", function () {
    e.fire({
      title: "Are you sure?",
      text: "Bạn có chắc chắn muốn xoá ca thi?",
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
          url: "./poetry/delete",
          data: {
            cathi: $(this).data("id"),
          },
          success: function (response) {
            if (response) {
              e.fire("Deleted!", "Xóa ca thi thành công!", "success");
              loadData();
            } else {
              e.fire("Lỗi !", "Xoá ca thi không thành công !)", "error");
            }
          },
        });
      }
    });
  });

  $(document).on("click", ".btn-detail", function () {
    $("#modal-add-poetry").modal("show");
    $("#btn-add-poetry").hide();
    $("#btn-update-poetry").show();
    clearInputFields();
    $.ajax({
      type: "post",
      url: "./poetry/getPoetryDetail",
      data: {
        cathi: $(this).data("id"),
      },
      dataType: "json",
      success: function (response) {
        console.log(response)
        $("#id_poetry").val(response["macathi"]);
        $("#tencathi").val(response["tencathi"]);
        $("#ngaythi").val(response["ngaythi"]);
        $("#thoigian").val(response['thoigianthi'])
        $("#dethi").val(response["made"]).trigger("change");
        $("#loaide").val(response["loaikythi"]).trigger("change");
        $("#cathi").val(response["khunggio"]).trigger("change");
      },
    });
  });

  $("#loaide").select2({
    dropdownParent: $("#modal-add-poetry"),
  });
  $("#dethi").select2({
    dropdownParent: $("#modal-add-poetry"),
  });
  $("#cathi").select2({
    dropdownParent: $("#modal-add-poetry"),
  });

  $("#btn-add-poetry").on("click", function (e) {
    e.preventDefault();
    if ($(".form-add-poetry").valid()) {
      $.ajax({
        type: "post",
        url: "./poetry/addPoetry",
        data: {
          tencathi: $("#tencathi").val(),
          dethi: $("#dethi").val(),
          cathi: $("#cathi").val(),
          ngaythi: $("#ngaythi").val(),
          loaide: $("#loaide").val(),
          thoigian: $("#thoigian").val()
        },
        success: function (response) {
            Dashmix.helpers("jq-notify", {
              type: "success",
              icon: "fa fa-check me-1",
              message: `Thêm ca thi thành công!`,
            });
            loadData();
            clearInputFields();
            $("#modal-add-poetry").modal("hide");
        },
      });
    }
  });
});

$("#btn-update-poetry").on("click", function (e) {
  e.preventDefault();
  if ($(".form-add-poetry").valid()) {
    $.ajax({
      type: "post",
      url: "./poetry/updatePoetry",
      data: {
        macathi: $("#id_poetry").val(),
        tencathi: $("#tencathi").val(),
        dethi: $("#dethi").val(),
        cathi: $("#cathi").val(),
        ngaythi: $("#ngaythi").val(),
        loaide: $("#loaide").val(),
        thoigian: $("#thoigian").val()
      },
      success: function (response) {
        if(response){
          Dashmix.helpers("jq-notify", {
            type: "success",
            icon: "fa fa-check me-1",
            message: `Cập nhật ca thi thành công!`,
          });
          loadData();
          clearInputFields();
          $("#modal-add-poetry").modal("hide");
        }
      },
    });
  }
});

function clearInputFields() {
  $("#tencathi").val("");
  $("#ngaythi").val("");
  $("#dethi").val("").trigger("change");
  $("#cathi").val("").trigger("change");
  $("#loaide").val("").trigger("change");
  $("#thoigian").val("")
}

// Get current user ID
// const container = document.querySelector(".content");
// const currentUser = container.dataset.id;
// delete container.dataset.id;

// // Pagination
// const mainPagePagination = new Pagination(null, null, showListTest);
// mainPagePagination.option.controller = "test";
// mainPagePagination.option.model = "DeThiModel";
// mainPagePagination.option.id = currentUser;
// mainPagePagination.option.custom.function = "getAllCreatedTest";
// mainPagePagination.getPagination(mainPagePagination.option, mainPagePagination.valuePage.curPage);
