function uploader() {
    this.upload = function(url, elementId, progress, complete) {
        var fileObj = $(elementId)[0].files;
        if (fileObj.length == 0) {
            return
        }
        var form = new FormData();
        form.append("count", fileObj.length);
        for (var i = 0; i < fileObj.length; i++) {
            form.append('file'+i, fileObj[i]);
        }


        // XMLHttpRequest 对象
        var xhr = new XMLHttpRequest();
        //true为异步处理
        xhr.open('post', url, true);
        //上传开始执行方法
        xhr.onloadstart = function() {
             console.log('开始上传')
        };

        xhr.upload.addEventListener('progress', progressFunction, false);
        xhr.addEventListener("load", uploadComplete, false);
        xhr.addEventListener("error", uploadFailed, false);
        xhr.addEventListener("abort", uploadCanceled, false);
        xhr.send(form);

        function progressFunction(evt) {
            if (evt.lengthComputable) {
                var completePercent = Math.round(evt.loaded / evt.total * 100)+ '%';
                if (progress != null) {
                    progress(completePercent)
                }
            }
        }

        //上传成功后回调
        function uploadComplete(evt) {
//            alert('上传完成')
            if (complete != null) {
                complete(true, evt)
            }
        };

        //上传失败回调
        function uploadFailed(evt) {
            alert('上传失败' + evt.target.responseText);
            if (complete != null) {
                complete(false)
            }
        }

        //终止上传
        function cancelUpload() {
            xhr.abort();
        }

        //上传取消后回调
        function uploadCanceled(evt) {
            alert('上传取消,上传被用户取消或者浏览器断开连接:' + evt.target.responseText);
        }
    }
}