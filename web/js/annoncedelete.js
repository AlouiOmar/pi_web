function dela(id) {
    $('#del').click(function (e) {
        e.preventDefault();
        var tthis = $(this);

        Swal.fire({
            title: 'Voulez vous supprimer cette annonce?',
            text: "Cette action est irréversible!",
            icon: 'warning',
            customClass: 'swal-height',
            width: '500px',
            height: '600px',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            console.log(result.value);
            if (result.value) {

                    Swal.fire({
                        customClass: 'swal-height',
                        title: 'Annonce supprimée!',
                        text: 'Vous allez être redirigé vers la liste des annonces.',
                        icon: 'success'
                    } ).then((e)=>{
                        console.log('a');
                        console.log(id);
                        document.location = 'http://localhost/pi/web/app_dev.php/admin/annonce/delete/'.concat(id);

                    })
            }
        })
    });}