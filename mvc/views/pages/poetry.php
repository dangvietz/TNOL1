<div class="content" data-id="<?php echo $data["user_id"] ?>">
    <form action="#" method="POST" id="search-form" onsubmit="return false;">
        <div class="row mb-4">
            <div class="col-6 flex-grow-1">
                <div class="input-group">
                    <button class="btn btn-alt-primary dropdown-toggle btn-filtered-by-state" id="dropdown-filter-state" type="button" data-bs-toggle="dropdown" aria-expanded="false">Tất cả</button>
                    <ul class="dropdown-menu mt-1" aria-labelledby="dropdown-filter-state">
                        <li><a class="dropdown-item filtered-by-state" href="javascript:void(0)" data-value="3">Tất cả</a></li>
                        <li><a class="dropdown-item filtered-by-state" href="javascript:void(0)" data-value="0">Chưa mở</a></li>
                        <li><a class="dropdown-item filtered-by-state" href="javascript:void(0)" data-value="1">Đang mở</a></li>
                        <li><a class="dropdown-item filtered-by-state" href="javascript:void(0)" data-value="2">Đã đóng</a></li>
                    </ul>
                    <input type="text" class="form-control" id="search-input" name="search-input" placeholder="Tìm kiếm Ca thi...">
                </div>
            </div>
            <div class="col-6 d-flex align-items-center justify-content-end gap-3">
                <button type="button" class="btn btn-hero btn-primary me-2" data-bs-toggle="modal" data-bs-target="#modal-add-poetry" id="btn-and" data-role="nguoidung" data-action="create">Thêm ca thi</button>
                <!-- <a data-role="dethi" data-action="create" class="btn btn-hero btn-primary" href="./test/add"><i class="fa fa-fw fa-plus me-1"></i> Tạo Ca thi</a> -->
            </div>
        </div>
    </form>
    <div class="list-test" id="list-test">
    </div>
    <!-- <div class="row my-3"> -->
    <!-- <?php if (isset($data["Plugin"]["pagination"])) require "./mvc/views/inc/pagination.php" ?> -->
    <!-- </div> -->
</div>

<div class="modal fade" id="modal-add-poetry" tabindex="-1" role="dialog" aria-labelledby="modal-add-poetry" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-transparent bg-white mb-0 block-rounded">
                <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="btabs-static-home-tab" data-bs-toggle="tab" data-bs-target="#btabs-static-home" role="tab" aria-controls="btabs-static-home" aria-selected="true">
                            Thêm thủ công
                        </button>
                    </li>
                    <li class="nav-item ms-auto">
                        <button type="button" class="btn btn-close p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <form novalidate="novalidate" onsubmit="return false;" class="tab-pane active form-add-poetry" id="btabs-static-home" role="tabpanel" aria-labelledby="btabs-static-home-tab" tabindex="0">
                        <div class="mb-4">
                            <label for="tencathi" class="form-label">Tên ca thi</label>
                            <input type="text" class="form-control" name="tencathi" id="tencathi" placeholder="Nhập tên ca thi">
                        </div>
                        <div class="mb-4">
                            <label for="dethi" class="form-label">Chọn đề thi</label>
                            <select class="js-select2 form-select data-nhomquyen" data-tab="1" id="dethi" name="dethi" style="width: 100%;" data-placeholder="Choose one..">
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="cathi" class="form-label">Chọn ca thi</label>
                            <select class="js-select2 form-select data-nhomquyen" data-tab="1" id="cathi" name="cathi" style="width: 100%;" data-placeholder="Choose one..">
                                <option value="">Chọn khung giờ</option>
                                <option value="7:30-9:00">7:30-9:00</option>
                                <option value="9:00-11:00">9:00-11:00</option>
                                <option value="13:00-14:30">13:00-14:30</option>
                                <option value="15:00-16:30">15:00-16:30</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="ngaythi" class="form-label">Chọn ngày thi</label>
                            <input type="text" class="js-flatpickr form-control form-control-alt" id="ngaythi" name="ngaythi" placeholder="Ngày thi">
                        </div>
                        <div class="mb-4">
                            <label for="tencathi" class="form-label">Thời gian làm bài</label>
                            <input type="text" class="form-control" name="thoigian" id="thoigian" placeholder="Nhập tên thời gian làm bài...">
                        </div>
                        <div class="mb-4">
                            <label for="loaide" class="form-label">Loại đề thi</label>
                            <select class="js-select2 form-select data-nhomquyen" data-tab="1" id="loaide" name="loaide" style="width: 100%;" data-placeholder="Choose one..">
                                <option value="">Chọn loại đề thi</option>
                                <option value="giua_ky">Giữa kỳ</option>
                                <option value="cuoi_ky">Cuối kỳ</option>
                            </select>
                        </div>
                        <input type="hidden" id="id_poetry">
                        <div class="block-content block-content-full text-end">
                            <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-sm btn-primary add-poetry-element" id="btn-add-poetry">Lưu</button>
                            <button type="button" class="btn btn-sm btn-primary update-poetry-element" id="btn-update-poetry" data-id="">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>