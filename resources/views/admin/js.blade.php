<link href="/css/bootstrap-switch.css" rel="stylesheet">
<!-- Scripts -->

<script type="text/javascript" src="/js/bootstrap-checkbox.js"></script>
<script type="text/javascript" src="/js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="/js/notify.min.js"></script>


<script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function () {

        $(".collapse").collapse({
            toggle: false
        });

        $(document).on("change", ".cats", function () {
            var catId = $(this).val();
            var albomId = $(this).attr('data-id');
            var catTitle = $.trim($('option:selected', this).text());
            console.log(catTitle);
            $('.addCat[albom-id=' + albomId + ']').attr('data-id', catId);
            $('.addCat[albom-id=' + albomId + ']').attr('data-title', catTitle);
            // $('#select option[albom-id=4]')
        });

        $(document).on("change", ".allAlboms", function () {
            console.log($(this).is(':checked'));
            if ($(this).is(':checked')) {
                $('.allCats').removeClass('hidden');
                $('.albomId').addClass('hidden');
            } else {
                $('.allCats').addClass('hidden');
                $('.albomId').removeClass('hidden');
            }
        });

        $(document).on("change", ".allAlbomsGen", function () {
            if ($(this).is(':checked')) {
                $('.albmId').addClass('hidden');
            } else {
                $('.albmId').removeClass('hidden');
            }
        });

        $(document).on("change", ".pagesCats", function () {
            var catId = $('option:selected', this).val();
            var pageId = $('option:selected', this).attr('page-id');
            console.log('catId: ' + catId + '; pageId: ' + pageId);
            $.ajax({
                url: '/admin/pages/change_page_cat',
                type: 'POST',
                data: {"_token": CSRF_TOKEN, "catId": catId, "pageId": pageId},
                dataType: 'JSON',
                success: function (data) {
                    if (data.status == 'ok') {
                        $.notify(data.message, "success");

                    }
                    else if (data.status == 'error') {
                        $.notify(data.message, "error");
                    }
                }
            });
            return false;
        });

        $(document).on("change", ".albs", function () {
            var albomId = $('option:selected', this).attr('albom-id');
            var imageId = $(this).attr('data-id');
            console.log('albId: ' + albomId + '; ' + imageId);
            $.ajax({
                url: '/admin/images/change_image_albom',
                type: 'POST',
                data: {"_token": CSRF_TOKEN, "albomId": albomId, "imageId": imageId},
                dataType: 'JSON',
                success: function (data) {
                    if (data.status == 'ok') {
                        $.notify(data.message, "success");

                    }
                    else if (data.status == 'error') {
                        $.notify(data.message, "error");
                    }
                }
            });
            return false;
        });

        $(document).on("click", ".addCat", function () {
            var catId = $(this).attr('data-id');
            var albomId = $(this).attr('albom-id');
            var catTitle = $(this).attr('data-title');
            console.log(catId);
            $.ajax({
                url: '/admin/alboms/add_cat',
                type: 'POST',
                data: {"_token": CSRF_TOKEN, "catId": catId, "albId": albomId},
                dataType: 'JSON',
                success: function (data) {
                    if (data.status == 'ok') {
                        $.notify(data.message, "success");
                        $('.block[data-id=' + albomId + ']').append('<div class="catsSel" alb-id="' + albomId + '" cat-id="' + catId + '">' + catTitle + '<a href="#" class="delCat" data-id="' + catId + '" albom-id="' + albomId + '"><i class="fa fa-fw fa-minus-square"></i></a></div>');
                    }
                    else if (data.status == 'error') {
                        $.notify(data.message, "error");
                    }
                }
            });
            return false;
        });

        $(document).on("click", ".delCat", function () {
            var catId = $(this).attr('data-id');
            var albomId = $(this).attr('albom-id');
            console.log(catId);

            $.ajax({
                url: '/admin/alboms/del_cat',
                type: 'POST',
                data: {"_token": CSRF_TOKEN, "catId": catId, "albId": albomId},
                dataType: 'JSON',
                success: function (data) {
                    if (data.status == 'ok') {
                        $.notify(data.message, "success");
                        $('.catsSel[alb-id=' + albomId + '][cat-id=' + catId + ']').remove();
                    }
                    else if (data.status == 'error') {
                        $.notify(data.message, "error");
                    }
                }
            });
            return false;
        });

        $(document).on("click", ".close_win", function () {
            var id = $(this).attr('data-id');
            // console.log(id);
            $("#editSetting" + id + "").modal('hide');
            $("#editCategory" + id + "").modal('hide');
            $("#createCategory" + id + "").modal('hide');
            $("#createSetting" + id + "").modal('hide');
            $("#editAlbom" + id + "").modal('hide');
            $("#createAlbom" + id + "").modal('hide');
            $("#createImage" + id + "").modal('hide');
            $("#editImage" + id + "").modal('hide');
            $("#createPage" + id + "").modal('hide');
            $("#editPage" + id + "").modal('hide');
        });

        $('#delete_modal').modal({
            show: false
        });

        $('.delete_toggler').each(function (index, elem) {
            $(elem).click(function () {
                $('#postvalue').attr('value', $(elem).attr('rel'));
                arr = selected.split(',');
                popped = arr.pop();
                $('.albSel').attr('value', $('#alb' + popped + ' :selected').attr('albom-id'));
                $('#delete_modal').modal('show');
            });
        });

        $(".categories-visible").bootstrapSwitch();

        $().checkbox({delete_closure: function (selected) {
                //console.log(selected);
                arr = selected.split(',');
                popped = arr.pop();
                $('.albSel').attr('value', $('#alb' + popped + ' :selected').attr('albom-id'));
                $('#postvalue').attr('value', selected);
                $('#delete_modal .modal-body span').text(selected);
                $('#delete_modal').modal('show');
            }});

        $('.categories-visible').on('switchChange.bootstrapSwitch', function (event, state) {

            var catId = $(this).attr('data-id');

            if (state) {
                st = 1;
            } else {
                st = 0;
            }

            // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/admin/categories/on_off',
                type: 'POST',
                data: {"_token": CSRF_TOKEN, "catId": catId, "state": st},
                dataType: 'JSON',
                success: function (data) {
                    if (data.status == 'ok') {
                        $.notify(data.message, "success");
                    }
                    else if (data.status == 'error') {
                        $.notify(data.message, "error");
                    }
                }
            });

        });

        $('#SelectAllVisible').click(function () {
            var state = $(this).prop('checked');
            var urlPart = $(this).attr('data-url');
            //console.log(urlPart);
            var visible = 1;
            if (state)
                visible = 1;
            else
                visible = 0;
            $('tr input[type="checkbox"]:not(#SelectAll):not(.alboms-delete):not(.images-delete):not(.pages-delete)').each(function () {
                $(this).prop('checked', state);
            });
            var selected = new Array();
            var notselected = new Array();
            $('tr input[type="checkbox"]:not(#SelectAll):not(#SelectAllVisible):not(.categories-visible):not(.alboms-delete):not(.images-delete):not(.pages-delete)').each(function (index, elem) {

                if ($(elem).prop('checked') && $(elem).attr('id') != 'SelectAll' && $(elem).attr('id') != 'SelectAllVisible'
                        && $(elem).attr('class') != 'categories-visible'
                        && $(elem).attr('class') != 'alboms-delete'
                        && $(elem).attr('class') != 'images-delete'
                        && $(elem).attr('class') != 'pages-delete'
                        ) {

                    selected.push($(elem).attr('data-id'));
                    visible = 1;
                }

                if ((!$(elem).prop('checked')) && $(elem).attr('id') != 'SelectAll' && $(elem).attr('id') != 'SelectAllVisible'
                        && $(elem).attr('class') != 'categories-visible'
                        && $(elem).attr('class') != 'alboms-delete'
                        && $(elem).attr('class') != 'images-delete'
                        && $(elem).attr('class') != 'pages-delete'
                        ) {

                    selected.push($(elem).attr('data-id'));
                    visible = 0;
                }
            });
            if (selected.length > 0) {
                selected = selected.join();
                var page = $('#pageNumb').val();
                var url = '/admin/' + urlPart + '/change_visible_many';
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {"_token": CSRF_TOKEN, "visible": visible, "ids": selected, "page": page},
                    dataType: 'JSON',
                    success: function (data) {

                        if (data.status == 'ok') {

                            $.notify(data.message, "success");

                        }
                        else if (data.status == 'error') {
                            $.notify(data.message, "error");
                        }
                    }
                });
            }
        });

        $('.visible-change').click(function () {
            var state = $(this).prop('checked');
            var visible = null;
            var albId = $(this).attr('data-id');
            var urlPart = $(this).attr('data-url');
            if (state == true)
                visible = 1;
            else
                visible = 0;
            var page = $('#pageNumb').val();
            var url = '/admin/' + urlPart + '/change_visible_many';
            $.ajax({
                url: url,
                type: 'POST',
                data: {"_token": CSRF_TOKEN, "visible": visible, "ids": albId, "page": page},
                dataType: 'JSON',
                success: function (data) {
                    if (data.status == 'ok') {
                        $.notify(data.message, "success");
                    } else if (data.status == 'error') {
                        $.notify(data.message, "error");
                    }
                }
            });
        });

        $(document).on("click", "#add-title", function () {
            var titlesCount = $('#title_word_count').val();
            titlesCount++;
            $('#title-parts').append('<div class="form-group" id="word-title-part' + titlesCount + '"><label for="word_title' + titlesCount + '">' + titlesCount + '-я часть title</label><textarea class="form-control" name="word_title' + titlesCount + '" cols="50" rows="2" id="word_title' + titlesCount + '"></textarea></div>');
            //console.log('titlesCount: '+titlesCount);
            $('#title_word_count').val(titlesCount);
            return false;
        });

        $(document).on("click", "#remove-title", function () {
            var titlesCount = $('#title_word_count').val();
            if ($('#word-title-part' + titlesCount).length) {

                $('#word-title-part' + titlesCount).remove();
                titlesCount--;
                $('#title_word_count').val(titlesCount);
            }
            return false;
        });

    });
</script>

