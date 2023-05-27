                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-6">
                                    <label for="price">Giá nhập sản phẩm</label>
                                    <input type="text" name="price" value=" {{ old('price') }}" id="price"
                                        class="form-control" placeholder="Giá nhập sản phẩm">
                                    @if ($errors->has('price'))
                                        <div class="text-danger">
                                            {{ $errors->first('price') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-6">
                                    <label for="qty">Số lượng</label>
                                    <input type="number" name="qty" value=" {{ old('qty') }}" id="qty"
                                        class="form-control" placeholder="Số lượng">
                                    @if ($errors->has('qty'))
                                        <div class="text-danger">
                                            {{ $errors->first('qty') }}
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
