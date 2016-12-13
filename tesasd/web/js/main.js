var menuImageHash;
var downloadLink;
$(document).ready(function() {
    if($("#lightgallery").length > 0){
        $("#lightgallery").lightGallery();
    }

    if($("#my-awesome-dropzone").length > 0){
        Dropzone.options.myAwesomeDropzone = {
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 10, // MB
            clickable: false,
            dictDefaultMessage: "",
            previewTemplate: document.getElementById('preview-template').innerHTML,
            previewsContainer: ".new-content-upload",
            thumbnailWidth: 400,
            thumbnailHeight: 300,
            acceptedFiles: "image/*",
            dictResponseError: "test",
            dictInvalidFileType: "Es können nur Bilder hochgeladen werden. Bitte versuche es erneut."
        };
    }
});


// Rechtsklick Men�

$('html')
    .delegate('[contextmenu]', 'contextmenu', function (e) {
        var contextmenu  = $(this).attr('contextmenu');
        menuImageHash  = $(this).attr('imageHash');
        downloadLink = $(this).parent().parent().attr('data-src');
        var $contextmenu = $('#' + contextmenu);


        var test = $("menu#copy-paste").find("[data-menupoint=download]");

        var link = '<i class="fa fa-download" aria-hidden="true"></i> <a target="_blank" download="" href="'+downloadLink+'">Download</a>';

        test.html(link);

        if ($contextmenu.length == 0) {
            return;
        }


        e.preventDefault();
        e.stopPropagation();


        var menuOffset = $(window).scrollTop();
        var menuOffsetTop = e.pageY - menuOffset;
        var menuHeight = $contextmenu.outerHeight();
        var windowHeight = $(window).height();
        var menuOffsetHeight = menuOffsetTop + menuHeight;

        if(menuOffsetHeight > windowHeight){
            console.log( menuOffsetHeight - windowHeight);
            menuOffset = menuOffset + (menuOffsetHeight - windowHeight + 10);
        }

        //console.log(e.pageY - menuOffset);
        //console.log($contextmenu.height());
        //console.log($(window).height());





        $contextmenu.show();
        $contextmenu.css({
            'top' : (e.pageY - menuOffset) + 'px',
            'left': (e.pageX + 10) + 'px'
        });

        return false;
    })

    .on({
        'keydown' : function (e) {
            if (e.which == 27) {
                $('menu[type=context]').hide();
            }
        },

        'click' : function () {
            $('menu[type=context]').hide();
        }
    });


//Menühandling

$( "menu#copy-paste li" ).on( "click", function() {

        if(menuImageHash != null){
            var clickedMenuPoint  = $(this).attr('data-menuPoint');

            switch(clickedMenuPoint) {
                case "details":
                    console.log(clickedMenuPoint);
                    break;
                case "addPassword":
                    console.log(clickedMenuPoint);
                    break;
                case "removePassword":
                    console.log(clickedMenuPoint);
                    break;
                case "rename":
                    console.log(clickedMenuPoint);
                    break;
                case "visable":
                    console.log(clickedMenuPoint);
                    break;
                case "hidden":
                    console.log(clickedMenuPoint);
                    break;
                case "share":
                    console.log(clickedMenuPoint);
                    break;
                case "restore":
                    restoreFile(menuImageHash);
                    break;
                case "delete":
                    removeFileToTrash(menuImageHash);
                    break;
                case "deleteImageComplete":
                    removeFile(menuImageHash);
                    break;
                default:
            }
        }
});


function removeFileToTrash(imageHash){
    $.ajax({
        type: "POST",
        url: "/ajax",
        data: {
            ajaxCall: "removeFileToTrash",
            imageHash: imageHash
        },
        success: function(response) {
            console.log(response);
        }
    });
}

function removeFile(imageHash){
    $.ajax({
        type: "POST",
        url: "/ajax",
        data: {
            ajaxCall: "removeFile",
            imageHash: imageHash
        },
        success: function(response) {
            //console.log(response);
        }
    });
}

function removeFile(imageHash){
    $.ajax({
        type: "POST",
        url: "/ajax",
        data: {
            ajaxCall: "removeFile",
            imageHash: imageHash
        },
        success: function(response) {
            console.log(response);
        }
    });
}

function restoreFile(imageHash){
    $.ajax({
        type: "POST",
        url: "/ajax",
        data: {
            ajaxCall: "restoreFile",
            imageHash: imageHash
        },
        success: function(response) {
            console.log(response);
        }
    });
}