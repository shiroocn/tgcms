function viewImg(obj) {
    console.log(obj.src);
    $('#viewImg').attr('src',obj.src);
    $('#exampleModalCenter').modal('toggle');
}