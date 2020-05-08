let fileInput = document.getElementById('img__input'),
    widthInput=document.getElementById('img__width'),
    heightInput=document.getElementById('img__height'),
    saveButton= document.getElementById('img__saveButton')
;

fileInput.addEventListener('change', fileInit);
saveButton.addEventListener('click', saveImage)
let fileBox = [];

//инициализация файла:
//внос существующих размеров изображения в форму
//подготовка файла к отправке на сервер
function fileInit(e) {
    e.preventDefault();
    let files = [...this.files];
    let reader = new FileReader();
    reader.readAsDataURL(files[0]);

    reader.onload=function (){
        let img = new Image();
        img.src=reader.result;
        img.onload = function(){
            widthInput.value=img.width;
            heightInput.value=img.height;
        }
    }
    fileBox.push(files[0]);
}

//отправка на сервер заданных пользвателем размеров изображения
//ajax-запрос
function saveImage(e) {
    e.preventDefault();
    let fd = new FormData();
    fd.append('imgToProcess', fileBox[0], fileBox[0].name);
    fd.append('imgWidth', widthInput.value);
    fd.append('imgHeight', heightInput.value);

    $.ajax({
        url:'./resize.php',
        type:'POST',
        data:fd,
        contentType:false,
        processData: false,
        success:function (xhr, textStatus, response) {
            let status = response.status;
            let data = JSON.parse(response.responseText);
            let id = data.id;
            let imgName=data.new_img_name;
            let link = document.createElement('a');
            link.innerHTML='download';
            link.href='/download.php?id='+id+'&imgname='+imgName+'&status='+status;
            document.getElementsByTagName('body')[0].appendChild(link);
        }
    })
}