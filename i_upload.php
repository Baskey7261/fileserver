<html>

<head>

    <link rel="stylesheet" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Preview</title>

</head>
<script src="js/jquery.js"></script>
<script src="js/main.js">
</script>
<script>
    fileViewer();

    function reload() {
        location.reload(true);
    }
</script>


<body>



    <div id="wrapper" style="margin-top:100px;">
        <h2 style="text-align:center;margin:10px 0px 10px 0px;" id="uploadHeader">Upload files</h2>
        <div id="previewWrapper" onclick="menuToggle2()">
            <div id="preview">
                <img src="" id="previewImage">
                <img src="assets/fileicon.png" id="previewImage2">
            </div>
            <div id="fileInfo">
                <ul style="list-style:none;text-align:center;margin:5px 0px 5px 0px;padding:0px;">
                    <li>&nbsp</li>
                    <li>&nbsp</li>
                </ul>
            </div>
        </div>

        <form id="frm1" method="post" action="" enctype="multipart/form-data">
            <input name="postID" id="postId" type="hidden">
            <input name="uploadTime" id="uploadTime" type="hidden">

            <div id="addTextSection">
                <input id="postSubject" type="text" name="subject" placeholder="Subject">
                <input id="headerText" type="text" name="headerText" placeholder="Enter your name">
                <p>Add caption.</p>
                <div id="captionText">
                    <p id="bodyText" class="editable" contenteditable="true" placeholder="Add caption"></p>
                    <input id="bodyTxt" name="bodyText" type="hidden">
                </div>
                <div id="uploadButtonWrapper">
                <input id="getFile" name="file" type="file" onchange="imagePreview()" />
                <label for="getFile" id="getFileButton">Choose a file</label>
                <button id="upLoadButton" type="" onclick="">Post</button>
                <br>
            </div>

            </div>
        </form>
    </div>
</body>
<script>
    $('#upLoadButton').click(function(event) {
    event.preventDefault();
    //alert("Was preventDefault() called: " + event.isDefaultPrevented());
});
</script>
</html>