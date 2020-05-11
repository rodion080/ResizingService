let imageForm= document.getElementById('img__form'),
    fileInput = document.getElementById('img__input'),
    widthInput=document.getElementById('img__width'),
    heightInput=document.getElementById('img__height'),
    saveButton= document.getElementById('img__saveButton')
;


saveButton.addEventListener('click', saveImage);
fileInput.addEventListener('change', fileInit);
let fileBox = [];

//инициализация файла:
//внос существующих размеров изображения в форму
//подготовка файла к отправке на сервер
function fileInit(e) {
        e.preventDefault();
        let files = [...this.files];
        let reader = new FileReader();
        reader.readAsDataURL(files[0]);

        reader.onload = function () {
            let img = new Image();
            img.src = reader.result;
            img.onload = function () {
                widthInput.value = img.width;
                heightInput.value = img.height;
            }
        }
        fileBox.push(files[0]);
    }

//отправка на сервер заданных пользвателем размеров изображения
//ajax-запрос
function saveImage(e) {
        e.preventDefault();

        if (fileBox.length == 0) {
            alert("Загрузите пожалуйста файл для обработки");
            return;
        }

        let fd = new FormData();
        fd.append('img_name', fileBox[0].name);
        fd.append('img_status', 'ongoing');

        $.ajax({
            url: './dbupload.php',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function (xhr, textStatus, response) {
                imageForm.style.display='none';
                let data = JSON.parse(response.responseText);
                let id = data.id;
                let name = data.name;
                let link = document.createElement('a');
                link.innerHTML = 'download';
                link.href = '/download.php?id=' + id;
                document.body.innerHTML+="Началась обработка изображения,";
                document.body.innerHTML+="<br>";
                document.body.innerHTML+="результат можно унать пройдя по ссылке:";
                document.getElementsByTagName('body')[0].appendChild(link);
                resizeImage(id, name, widthInput.value, heightInput.value);
            }
        })
    }


function resizeImage(id, name, width, height){
    let fd = new FormData();
    fd.append('imgToProcess', fileBox[0], name);
    fd.append('imgWidth', width);
    fd.append('imgHeight', height);
    fd.append('imgId', id)

    $.ajax({
        url: './resize.php',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
    })

} 


