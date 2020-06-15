function delu(id,idco) {
    $('#del').click(function (e) {
        e.preventDefault();
        var tthis = $(this);

        Swal.fire({
            title: 'Voulez vous supprimer cet utilisateur?',
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
                if(id!=idco){
                Swal.fire({
                    customClass: 'swal-height',
                    title: 'Utilisateur supprimé!',
                    text: 'Vous allez être redirigé vers la liste des utilisateurs.',
                    icon: 'success'
                } ).then((e)=>{
                    console.log('a');
                    console.log(id);
                    document.location = 'http://localhost/pi/web/app_dev.php/admin/delete/user/'.concat(id);

                })}else {
                    Swal.fire({
                        customClass: 'swal-height',
                        title: 'Utilisateur non supprimé!',
                        text: 'Vous ne pouvez pas vous supprimer.',
                        icon: 'error'
                    } )
                }
            }
        })
    });}