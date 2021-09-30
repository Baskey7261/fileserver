function currentTime() {
    var d = new Date();
    var days = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"];
    var month = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"];
    var year = d.getFullYear();
    var mon = month[d.getMonth()];
    var day = days[d.getDay()];
    var dymn = d.getDate();
    var hour = d.getHours();
    if (d.getMinutes() < 10) {
        var min = "0" + d.getMinutes()
    } else {
        var min = d.getMinutes();
    }
    return day + " " + dymn + " " + mon + " " + hour + ":" + min;
}








var filesArray = [];

function rndmStr(x) {
    var s = "",
        i = 0;
    while (i < x) {
        var r = Math.random(),
            n = Math.floor((Math.random() * 10) + 0);
        s += (r >= .5 ? n : String.fromCharCode(Math.floor(r * 51) + (r < .25 ? 97 : 65)));
        i++;
    };

    return s;
}
var postUrl = "upload.php";





function submitData() {
    var bodytext = $("#bodyText").text();
    $("#bodyTxt").val(bodytext);
    $("#uploadTime").val(currentTime());
    console.log(bodytext);
    $('#previewImage').attr('src', 'assets/loading.gif');
    $('#uploadHeader').text('Uploading file...');
    var frm = document.getElementById("frm1");
    $.ajax({
        url: postUrl,
        type: "POST",
        data: new FormData(frm),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            $("#previewImage").css({ 'display': 'block' });
            $("#previewImage2").css({ 'display': 'none' });

            console.log("here is the data " + data);
            $('#previewImage').attr('src', 'assets/checkmark.gif');
            setTimeout(function() {
                $('#previewImage').attr('src', 'assets/checkmark2.gif');
            }, 1500);
            $("#uploadHeader").text('Upload files');
            $("#fileInfo ul li:nth-child(1)").text("");
            $("#fileInfo ul li:nth-child(2)").text("Upload successful");
            fileViewer();
        }
    });
    $("#upLoadButton").attr('onclick', '');
    $("#upLoadButton").css({ 'cursor': 'default' });
    $("#upLoadButton").css({ 'background-color': '#C7D0D6' });
    $("#upLoadButton").css({ 'color': '#4e4e4e' });
}

function imagePreview() {
    var files = document.getElementById("getFile").files;
    var fileName = files["0"].name;
    var fileSize = files["0"].size;
    if (fileSize.toString().length <= 6) {
        fileSize = Math.floor(fileSize / 1014);
        fileSize = fileSize.toString() + " kb";
    } else if (fileSize.toString().length > 6) {
        fileSize = Math.floor(fileSize / 1000000);
        fileSize = fileSize.toString() + " mb";
    }
    var strt = fileName.lastIndexOf(".");
    var ext = fileName.substring(strt);
    var fileTypes = [
        [".txt", ".text", ".rtf", ".ini", ".inf"],
        [".php", ".css", ".js", ".dll", ".xml"],
        [".mpg", ".mp4", ".wmv", ".avi"],
        [".html"],
    ];

    fileTypes.map(function(e, i, a) {
        if (e.indexOf(ext) !== -1) {
            str = i;
        }
    }, str = "")

    var icons = ["texticon.png", "codeicon.png", "videoicon.png", "htmlicon.png", "fileicon.png"];
    if (str !== "") {
        $("#previewImage").css({ 'display': 'none' });
        $("#previewImage2").css({ 'display': 'block' });
        $('#previewImage2').attr('src', 'assets/' + icons[str]);
    } else {
        $("#previewImage").css({ 'display': 'block' });
        $("#previewImage2").css({ 'display': 'none' });
        $('#previewImage2').attr('src', 'assets/' + icons[4]);
    };

    var reader = new FileReader();
    reader.onload = function(e) {
        var image = new Image();
        image.src = e.target.result;
        image.onload = function() {
            var rot;
            if (this.height > this.width) {
                rot = 360;
            } else {
                rot = 270;
            }
            $("#rotAtion").val(rot);
            $("#upLoadButton").attr('onclick', 'submitData()');
            $("#upLoadButton").attr('type', 'submit');
        }

        $("#previewImage").attr('src', e.target.result);
        $("#upLoadButton").css({ 'cursor': 'pointer' });
        $("#upLoadButton").css({ 'background-color': '#56BB51' });
        $("#upLoadButton").css({ 'color': '#fff' });
    };
    reader.readAsDataURL(files[0]);

    $("#fileInfo ul li:nth-child(1)").text(fileName);
    $("#fileInfo ul li:nth-child(2)").text(fileSize);
    $("#postId").val(rndmStr(16));
}

function fileViewer() {
    $.ajax({
        url: "viewhandler.php",
        type: "POST",
        data: "",
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            data = JSON.parse(data);
            scanFiles(data);
        }
    });
}

function scanFiles(x) {
    var img = [".jpg", ".png", ",gif", ".jpeg"];
    var vid = [".mp4", ".mpg", ",avi", ".wmv"];
    var doc = [".txt", ".text", ",html", ".php", ".css", ".ai", ".pdf", ".js", ".doc", ".ini"];
    var aud = [".mp3", ".m3u", ",m4a", ".wav"];
    x.map(function(e, i, a) {
        var pos = e.lastIndexOf(".");
        var ext = e.substr(pos);
        if (img.indexOf(ext) !== -1) {
            imgs.push(e);
        } else if (vid.indexOf(ext) !== -1) {
            vids.push(e);
        } else if (aud.indexOf(ext) !== -1) {
            auds.push(e);
        } else if (doc.indexOf(ext) !== -1) {
            docs.push(e);
        } else { others.push(e) }
    }, imgs = [], vids = [], docs = [], auds = [], others = []);
    var $a = [imgs, vids, auds, docs, others];

    $("#imgCount").text(' (' + imgs.length + ')');
    $("#vidCount").text(' (' + vids.length + ')');
    $("#audCount").text(' (' + auds.length + ')');
    $("#docCount").text(' (' + docs.length + ')');
    $("#otherCount").text(' (' + others.length + ')');
    filesArray = $a;
    return $a;
}

function menuToggle1() {
    $("#dropDown1").slideToggle();
}

function menuToggle2() {
    $("#dropDown1").slideUp();
};

function slideInLeft(x, y) {
    $('#dropDown1').slideUp(function() {
        $(".viewPages").animate({ left: '-700px' }, function() {
            $(x).animate({ left: '0px' }, function() {
                $("#imgGal").html(showFiles(x, y));
            });
        });
    });
    showFiles(x, y);
};

function showFiles(x, y) {
    filesArray[y].map(function(e, i, a) {
        var src = 'testfolder/' + e;
        str += '<div id="imgThumb" onclick="showBig(' + "'" + src + "'" + ')"><img src="' + src + '"></div>';
    }, str = "");
    return str;
}

function showBig(x) {
    console.log("hello");
    $("#bigImge").show();
    $("#bigImge img").attr('src', x);

}


function topNavBack() {
    $(".viewPages").animate({ left: '-700px' });
}