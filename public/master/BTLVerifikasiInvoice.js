$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = base_url + 'assets/plugin/jFileUpload/server/php/',
        uploadButton_1 = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            }),
        uploadButton_2 = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            }),
        uploadButton_3 = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });

            
    $('#fileupload_1').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(pdf)$/i,
        // upload file max 20MB
        maxFileSize: 2000000
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files_1');
        $.each(data.files, function (index, file) {
            var node = $('<p/>').append($('<span/>'));
            if (!index) {
                node.append(uploadButton_1.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.error) {
            alert(file.error);
            data.context.find('button').remove();
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress_1 #progress-bar_1').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                $("#filename_1").val(file.name);
                $("#fileupload_1").attr('disabled', true);
                $("#btnCancel_1").removeAttr('style');
                $("#btnCancel_1").on("click", function() {
                    $("#filename_1").val('');
                    $("#fileupload_1").attr('disabled', false);
                    $(this).hide();
                    $('#progress_1 #progress-bar_1').css('width','0%');
                });
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

    $('#fileupload_2').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(pdf)$/i,
        // upload file max 20MB
        maxFileSize: 2000000
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files_2');
        $.each(data.files, function (index, file) {
            var node = $('<p/>').append($('<span/>'));
            if (!index) {
                node.append(uploadButton_2.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.error) {
            alert(file.error);
            data.context.find('button').remove();
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress_2 #progress-bar_2').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                $("#filename_2").val(file.name);
                $("#fileupload_2").attr('disabled', true);
                $("#btnCancel_2").removeAttr('style');
                $("#btnCancel_2").on("click", function() {
                    $("#filename_2").val('');
                    $("#fileupload_2").attr('disabled', false);
                    $(this).hide();
                    $('#progress_2 #progress-bar_2').css('width','0%');
                });
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

    $('#fileupload_3').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(pdf)$/i,
        // upload file max 20MB
        maxFileSize: 2000000
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files_3');
        $.each(data.files, function (index, file) {
            var node = $('<p/>').append($('<span/>'));
            if (!index) {
                node.append(uploadButton_3.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.error) {
            alert(file.error);
            data.context.find('button').remove();
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress_3 #progress-bar_3').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                $("#filename_3").val(file.name);
                $("#fileupload_3").attr('disabled', true);
                $("#btnCancel_3").removeAttr('style');
                $("#btnCancel_3").on("click", function() {
                    $("#filename_3").val('');
                    $("#fileupload_3").attr('disabled', false);
                    $(this).hide();
                    $('#progress_3 #progress-bar_3').css('width','0%');
                });
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');



    // post data
    $("#btnVerifikasiSubmit").on("click", function() {
        var BTL = $("#filename_1").val(),
            REKAPAN = $("#filename_2").val(),
            SCANNOTA = $("#filename_3").val();

        if (BTL!='' || REKAPAN!='' || SCANNOTA!='') {
            $.ajax({
                url: base_url + 'VerifikasiInvoice/save/',
                type: 'POST',
                data: { BTL: BTL, REKAPAN: REKAPAN, SCANNOTA: SCANNOTA },
                success: function(result, status, xhr) {
                    alert(result);
                    console.log(result, status, xhr);
                },
                error: function(status, xhr, error) {
                    alert("error, check console browser");
                    console.log(status, xhr, error);
                }
            });
        } else {
            alert("form is empty");
        }
    });
});