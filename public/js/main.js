
// Vérification des mots de passes!!
function validation(f) {
  if (f.password.value == '' || f.verif_password.value == '') {
    alert('Merci de remplir les deux champs mot de passe');
    f.password.focus();
    return false;
    }
  else if (f.password.value != f.verif_password.value) {
    alert('Ce ne sont pas les mêmes mots de passe!');
    f.password.focus();
    return false;
    }
  else if (f.password.value == f.verif_password.value) {
    return true;
    }
  else {
    f.password.focus();
    return false;
    }
  }
   
  // Vérification des modifs de commentaire!!
    function Empty(){
      let stc = document.forms['myForms'].editcomcontent.value;
      if( !stc.replace(/\s+/, '').length ) {
        alert( "Merci de ne pas mettre un commentaire vide" );
        return false;
      } 
    }

  // Vérification des modifs de sujet!!
    function isEmpty(){
      let str = document.forms['myForm'].contentSubj.value;
      let stt = document.forms['myForm'].titleSubj.value;
      if( !str.replace(/\s+/, '').length ) {
        alert( "Merci de ne pas mettre un sujet vide" );
          return false;
      }
      if( !stt.replace(/\s+/, '').length ) {
        alert( "Merci de ne pas mettre un titre vide" );
        return false;
      }
      }

// Retour en haut de page
  document.addEventListener('DOMContentLoaded', function() {
  window.onscroll = function(ev) {
  document.getElementById("cRetour").className = (window.pageYOffset > 100) ? "cVisible" : "cInvisible";
    };
  });


//MODAL//

/*     // Elements
		let overlay = document.getElementById('overlay');
		let modal = document.getElementById('modal');
		let open = document.getElementById('open');
		let close = document.getElementById('close');

		// Open
		open.addEventListener('click', function (e) {
			overlay.classList.add('visible');
			modal.classList.add('visible');
		});

		// Close
		close.addEventListener('click', function (e) {
			overlay.classList.remove('visible');
			modal.classList.remove('visible');
		}); */

//MENU ADMIN

let click_article1 = document.getElementById("click1");
let click_article2 = document.getElementById("click2");
let click_article3 = document.getElementById("click3");

let authors = document.getElementById("authors");
let posts = document.getElementById("posts");
let category = document.getElementById("category");

click_article1.addEventListener("click", function() {
  click_article1.style.backgroundColor="blue";
  click_article2.style.backgroundColor="transparent";
  click_article3.style.backgroundColor="transparent";
  posts.style.display="block";
  authors.style.display="none";
  category.style.display="none";
});

click_article2.addEventListener("click", function() {
  click_article2.style.backgroundColor="blue";
  click_article3.style.backgroundColor="transparent";
  click_article1.style.backgroundColor="transparent";
  posts.style.display="none";
  authors.style.display="none";
  category.style.display="block";
});

click_article3.addEventListener("click", function() {
  click_article3.style.backgroundColor="blue";
  click_article2.style.backgroundColor="transparent";
  click_article1.style.backgroundColor="transparent";
  posts.style.display="none";
  authors.style.display="block";
  category.style.display="none";
});

/* function ConfirmDelete()
{
  var x = confirm("Are you sure you want to delete?");
  if (x)
      return true;
  else
    return false;
}  */

$('.btn-danger').on('click',function(e){
    e.preventDefault();
    let $a =$(this);
    let url = $a.attr('href');
    $a.text('Chargement');
    /* if (ConfirmDelete()){ */
      $.ajax(url)
      .done(function(data,text, jqxhr){
        $a.parents('tr').remove();
      })
      .fail(function(jqxhr){
        alert(jqxhr.responseText);
      })
      .always(function(){
      $a.text('supprimer');
      });
    /* } */
});
/* let request = new XMLHttpRequest();

request.open('GET','../../model/deleteModel.php',true);
request.onreadystatechange = function(){
  if(this.readyState == 4){
    if(this.status === 200){
      console.log(this.responseText);
    }
    else{
      console.log(this.responseText);
    }
    console.log(this.responseText);
  }
  console.log("statut : " + this.readyState);
};
request.send();
request = null; */






            
