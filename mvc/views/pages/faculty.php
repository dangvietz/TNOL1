<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Danh sách khoa</h3>
            <div class="block-options">
                <button type="button" class="btn btn-hero btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-subject" data-role="khoa" data-action="create"><i class="fa-regular fa-plus"></i> Thêm khoa</button>
            </div>
        </div>
        <div class="block-content">
            <form action="#" id="search-form" onsubmit="return false;">
                <div class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-alt" id="search-input" name="search-input" placeholder="Tìm kiếm khoa...">
                        <button class="input-group-text bg-body border-0 btn-search">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center">Mã khoa</th>
                            <th>Tên khoa</th>

                            <th class="text-center col-header-action">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="list-subject">
                    </tbody>
                </table>
            </div>
            <?php if (isset($data["Plugin"]["pagination"])) require "./mvc/views/inc/pagination.php" ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-subject" tabindex="-1" role="dialog" aria-labelledby="modal-add-subject" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title add-subject-element">Thêm khoa</h3>
                    <h3 class="block-title update-subject-element">Chỉnh sửa khoa</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <form class="block-content fs-sm form-add-subject">
                    <div class="mb-3">
                        <label for="" class="form-label">Mã khoa</label>
                        <input type="text" class="form-control form-control-alt" name="makhoa" id="makhoa" placeholder="Nhập mã khoa">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Tên khoa</label>
                        <input type="text" class="form-control form-control-alt" name="tenkhoa" id="tenkhoa" placeholder="Nhập tên khoa">
                    </div>
                    <div class="block-content block-content-full text-end">
                        <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-sm btn-primary add-subject-element" id="add_subject">Lưu</button>
                        <button type="button" class="btn btn-sm btn-primary update-subject-element" id="update_subject" data-id="">Cập nhật</button>
                    </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="makhoa_lop">
<input type="hidden" id="malop">

<div class="modal fade" id="modal-class" tabindex="-1" role="dialog" aria-labelledby="modal-class" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Danh sách lớp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-1">
                <div class="table-responsive">
                    <table class="table table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Tên lớp</th>
                                <th class="text-center col-header-action">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="showChapper"></tbody>
                    </table>
                </div>
                <div class="block block-rounded mb-3">
                    <div class="block-content pb-3">
                        <a data-role="chuong" data-action="create" class="fw-bold" data-bs-toggle="collapse" href="#collapseChapter" role="button" aria-expanded="false" aria-controls="collapseChapter" id="btn-add-class"><i class="fa fa-fw fa-plus"></i>Thêm lớp</a>
                        <div class="collapse" id="collapseChapter">
                            <form method="post" class="mt-2 form-class">
                                <div class="row mb-1">
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="name_class" id="name_class" placeholder="Nhập tên lớp">
                                    </div>
                                    <div class="col-4">
                                        <input type="hidden" name="mamon_chuong" id="mamon_chuong">
                                        <input type="hidden" name="machuong" id="machuong">
                                        <button id="add-class" type="submit" class="btn btn-alt-primary">Tạo
                                            lớp</button>
                                        <button id="edit-class" type="submit" class="btn btn-primary">Đổi
                                            tên</button>
                                        <button type="button" class="btn btn-alt-secondary close-class">Huỷ</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Thoát</button>
            </div>
        </div>
    </div>
</div>