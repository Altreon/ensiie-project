function ajoutMedia()
{
	ajouterSelectMedia();
}
function suppMedia()
{
	var nbMedias = document.getElementsByClassName( "selectName" ).length;
	if( nbMedias > 0 )
	{
		var medias = [];
		for( var i = 0; i < nbMedias; i++ )
		{
			medias[i] = document.getElementsByName( "media"+(i+1) )[0];
		}
		var parent = medias[medias.length - 1].parentElement.parentElement;
		parent.removeChild( medias[medias.length - 1].parentElement );
	}
}
function ajouterSelectMedia()
{
	var nbMedias = document.getElementsByClassName( "selectName" ).length;
		var id = "formAjout"
		var div             = document.createElement( "div" );
		var champ           = document.getElementById( id );
		var input           = document.createElement( "input" );
		
		input.type          = "file";
		input.name          = "media" + (nbMedias+1);
		input.accept		= ".jpg, .jpeg, .png"
		input.required      = "required";
		input.className     = "selectName";
		input.style.display = "inline";
		input.style.width   = "100%";

		div.style.display = "inline";

		var elementAAjouterApres = document.getElementById( "bAjoutMedia");
		div.appendChild( input );
		champ.insertBefore( div, elementAAjouterApres );
}

function verficationEnvoie()
{
	return true
	//Manque de temps
}