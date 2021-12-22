function eliminar() {
    let eliminar = confirm('¿Desea eliminar el rol?');
    let form = document.form;

    if (eliminar) {
        form.submit();
    }else{
        window.location = "http://localhost:8080/veterinaria/funcionarios/";
    }
}