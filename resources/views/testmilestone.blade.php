<x-app-layout :assets="$assets ?? []">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Milestone</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-3">
                                <div class="form-group">
                                    <label for="">Project ID</label>
                                    <input type="text" class="form-control" name="project_id" id="project_id" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label for="">Project Description</label>
                                <textarea class="form-control" name="proj_desc" rows="1" cols="3"></textarea>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success float-right mt-4 add_more">Add
                                    More</button>
                            </div>
                        </div>
                        <div class="copy hide">
                            <div class="row">

                                <div class="col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="">Field 1</label>
                                        <input type="text" class="form-control" name="field_1[]" id="field_1" />
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="">Field 2</label>
                                        <input type="text" class="form-control" name="field_2[]" id="field_2" />
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="">Field 3</label>
                                        <input type="text" class="form-control" name="field_3[]" id="field_3" />
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="">Field 4</label>
                                        <input type="text" class="form-control" name="field_4[]" id="field_4" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-success add_submore float-left mt-4">Add sub
                                        more</button>
                                    <button type="button"
                                        class="btn btn-danger sub_delete float-right mt-4">remove</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script>
        $(document).ready(function() {
            var html = $('.copy').css({
                "display": "none"
            });
            $('.add_more').click(function() {
                $(html).css({
                    'display': 'block'
                });
                $(html).after(html);
            });
        });
    </script>
</x-app-layout>
