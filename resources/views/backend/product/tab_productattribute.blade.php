                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nameg">Tên thuộc tính</label>
                                    <input type="text" name="nagme" value=" {{ old('name') }}" id="name"
                                        class="form-control" placeholder="Nhập tên sản phẩm">
                                    @if ($errors->has('name'))
                                        <div class="text-danger">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="metadescg">Mô tả</label>
                                    <textarea name="metagdesc" id="metadesc" class="form-control" placeholder="Nhập mô tả"> {{ old('metadesc') }}</textarea>
                                    @if ($errors->has('metadesc'))
                                        <div class="text-danger">
                                            {{ $errors->first('metadesc') }}
                                        </div>
                                    @endif
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nameg">Giá trị</label>
                                    <input type="text" name="namge" value=" {{ old('name') }}" id="name"
                                        class="form-control" placeholder="Nhập tên sản phẩm">
                                    @if ($errors->has('name'))
                                        <div class="text-danger">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="metadescg">Thứ tự</label>
                                    <textarea name="metgadesc" id="metadesc" class="form-control" placeholder="Nhập mô tả"> {{ old('metadesc') }}</textarea>
                                    @if ($errors->has('metadesc'))
                                        <div class="text-danger">
                                            {{ $errors->first('metadesc') }}
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
