$('.my').ready(function(){
  $('.my').change(function () {
    $('.chous').text(this.files.length + " файл загружен");
  });
});