function sign(id,path) {
    $('#signa').click(function (e) {
        e.preventDefault();
        var tthis = $(this);

        Swal.fire({
            title: 'Signaler l\'annonce aux administrateurs',
            text: "Dites aux administrateurs ce qui ne va pas avec cette annonce. Personne d’autre ne verra votre nom ou le contenu de votre signalement.",
            icon: 'warning',
            input: 'select',
            width: '850px',
            inputOptions: {
                'Contenu indésirable': 'Contenu indésirable',
                'Harcèlement': 'Harcèlement',
                'Discours haineux': 'Discours haineux',
                'Nudité': 'Nudité',
                'Violence': 'Violence',
                'Autre': 'Autre'
            },
            inputPlaceholder: 'Choisir la raison:',
            showCancelButton: true,
            cancelButtonText: 'Annuler',
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if (value) {
                        resolve()
                    } else {
                        resolve('Vous devez séléctionner un champ pour signaler l\'annonce :)')
                    }
                })
            }
        }).then((result) => {
            console.log(result.value);
            if (result.value) {
                Swal.fire(
                    'Annonce signalée!',
                    'Vous allez être redirigé vers la liste des annonces.',
                    'success'
                ).then((e)=>{
                    console.log('a');
                    console.log(id);
                    console.log(path.slice(0, -1).concat(result.value));
                    //document.location.href = path.slice(0, -1).concat(result.value);
                    var oldUrl = $(this).attr("href"); // Get current url
                    var link=path.slice(0, -1).concat(result.value).toString();
                     //tthis.replace(link);
                    document.location = link;
                    console.log(tthis.attr('href'));

                })
            }
        })
    });
}



const { value: fruit } = await

if (fruit) {
    Swal.fire(`You selected: ${fruit}`)
}
