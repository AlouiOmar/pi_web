function del() {
    $('#mod').click(function (e) {
        e.preventDefault();
        var tthis = $(this);

        Swal.fire({
            title: 'Voulez vous supprimer cette annonce?',
            text: "Cette action est irréversible!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            console.log(result.value);
            if (result.value) {
                Swal.fire(
                    'Annonce supprimée!',
                    'Vous allez être redirigé vers la liste des annonces.',
                    'success'
                ).then((e)=>{
                    console.log('a');
                    document.location.href = tthis.attr('href');

                })
            }
        })
    });}