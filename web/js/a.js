
function sweet1() {
    //console.log('great success');
    var a=$('.b').val();
    if(a=='Vélo'){
        console.log('velo selected');
        $( ".k" ).prop( "disabled", false );
    }
    if(a=='Pièce de rechange'){
        console.log('piece selected');
        $( ".k" ).prop( "disabled", true );
        $( ".k" ).val( " " );


    }
    if(a=='Accessoire'){
        console.log('acc selected');
        $( ".k" ).prop( "disabled", true );

    }
   // console.log(a);
    $(document).ready(function() {
        $('.js-datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
    });
}

$(function sweet() {
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
    });


   $( function myFunction() {
        var x = $("#g");
        x.onclick(console.log(x.value()));
        console.log(x);
    })

    $(document).ready(function() {
        $('#appbundle_annonce_categorie').click(function (e) {
            e.preventDefault();
            console.log('a');
        });
    });


    $( function a() {
      //console.log( 'a1'+$('#appbundle_annonce_categorie').value());
        //console.log('a');
        console.log('bbbbbbbbbbbbb');


    })
    $( function b() {
        //console.log( 'a1'+$('#appbundle_annonce_categorie').value());
        //console.log('a');
        console.log('bbbbbbbbbbbbb');


    })

    function a() {
        console.log('bbbbbbbbbbbbb');

    }

});