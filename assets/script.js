export default function(name) {
    return `Yo yo ${name} - welcome to Encore!`;
};

var i=0;

window.onload = () => {
    let links = document.querySelectorAll("[data-delete]");
    console.log("Les liens : "+links);
    for(let link of links){
        // On écoute le clic
        link.addEventListener("click", function(e){
            // On empêche la navigation
            e.preventDefault()

            // On demande confirmation
            if(confirm("Voulez-vous supprimer cette image ?")){
                // On envoie une requête Ajax vers le href du lien avec la méthode DELETE
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({'_token': this.dataset.token})
                }).then(
                    // On récupère la réponse en JSON
                    response => response.json()
                ).then(data => {
                    if(data.success)
                        this.parentElement.remove()
                    else
                        alert(data.error)
                }).catch(e => alert(e))
            }
        })
    }
    let listEntreprisesFiltered = document.getElementById('listEntreprisesFiltered');
    let buttons = document.getElementsByClassName('button');
    console.log("Les boutons : "+buttons);
    
    for (let button of buttons){
        console.log(button.getAttribute('href'));
        

        button.addEventListener('click', function() {

            // e.preventDefault();
            
            var listEntreprises = document.getElementsByName('entreprises');
            // console.log("filterByCategorie "+i);
            console.log(this.getAttribute('href'));
            console.log(this.getAttribute('name'));

            fetch(this.getAttribute('href'), {
                method:'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                },
                data:{idCategorie: this.getAttribute('name')},
                // dataType: 'application/json',
                
            })
            .then(
                // On récupère la réponse en JSON
                response => response.json(),
                
                )
            .then(data => {
                
                listEntreprisesFiltered.innerHTML="";
                console.log(data);



                
                var arr_from_json = JSON.parse(data);
                console.log(arr_from_json.length);

                if(arr_from_json.length==0){
                    var pTextError = document.createElement("p");
                    var textError = document.createTextNode("Aucun commerce ne correspond à cet catégorie");         // Create a text node
                    pTextError.appendChild(textError);
                    listEntreprisesFiltered.appendChild(pTextError);
                }
                
                for(let entreprise of arr_from_json){

                    var entreprises = document.createElement("div");
                    entreprises.setAttribute('class','row');
                    listEntreprisesFiltered.appendChild(entreprises);
                    var imgDiv = document.createElement("div");
                    imgDiv.setAttribute('class','col');
                    var infoEntrepriseDiv = document.createElement("div");
                    infoEntrepriseDiv.setAttribute('class','col');
                    entreprises.appendChild(imgDiv);
                    entreprises.appendChild(infoEntrepriseDiv);
                    var img=document.createElement("img");
                    imgDiv.appendChild(img);
                    
                    
                    img.setAttribute('alt',entreprise.images[0].texteAccompagnement);
                    img.setAttribute('src',"/uploads/"+entreprise.images[0].name);
                    img.setAttribute('class','imgPresentationEntreprise')
                    var infoEntrepriseUl = document.createElement("ul");
                    infoEntrepriseDiv.appendChild(infoEntrepriseUl);
                    
                    var nomNode = document.createElement("li");                 // Create a <li> node
                    var nomTextNode = document.createTextNode(entreprise.nom);         // Create a text node
                    nomNode.appendChild(nomTextNode);  
                    infoEntrepriseUl.appendChild(nomNode);

                    var rueNode = document.createElement("li");                 // Create a <li> node
                    var rueTextNode = document.createTextNode(entreprise.rue);         // Create a text node
                    rueNode.appendChild(rueTextNode);  
                    infoEntrepriseUl.appendChild(rueNode);

                    var codePostalNode = document.createElement("li");                 // Create a <li> node
                    var codePostalTextNode = document.createTextNode(entreprise.codepostal);         // Create a text node
                    codePostalNode.appendChild(codePostalTextNode);  
                    infoEntrepriseUl.appendChild(codePostalNode);

                    var villeNode = document.createElement("li");                 // Create a <li> node
                    var villeTextNode = document.createTextNode(entreprise.ville);         // Create a text node
                    villeNode.appendChild(villeTextNode);  
                    infoEntrepriseUl.appendChild(villeNode);

                    var telephoneNode = document.createElement("li");                 // Create a <li> node
                    var telephoneTextNode = document.createTextNode(entreprise.telephone);         // Create a text node
                    telephoneNode.appendChild(telephoneTextNode);  
                    infoEntrepriseUl.appendChild(telephoneNode);

                    var siteWebNode = document.createElement("li");                 // Create a <li> node
                    var siteWebTextNode = document.createTextNode(entreprise.siteweb);         // Create a text node
                    siteWebNode.appendChild(siteWebTextNode);  
                    infoEntrepriseUl.appendChild(siteWebNode);

                    var longDescriptionNode = document.createElement("li");                 // Create a <li> node
                    var longDescriptionTextNode = document.createTextNode(entreprise.longdescription);         // Create a text node
                    longDescriptionNode.appendChild(longDescriptionTextNode);  
                    infoEntrepriseUl.appendChild(longDescriptionNode);

                    var shortDescriptionNode = document.createElement("li");                 // Create a <li> node
                    var shortDescriptionTextNode = document.createTextNode(entreprise.shortdescription);         // Create a text node
                    shortDescriptionNode.appendChild(shortDescriptionTextNode);  
                    infoEntrepriseUl.appendChild(shortDescriptionNode);

                    
                    
                    var emailNode = document.createElement("li");              // Create a <li> node
                    
                    var emailTextNode = document.createElement("a",entreprise.email);         // Create a text node
                    emailTextNode.setAttribute('href',"mailto: "+entreprise.email);
                    var email = document.createTextNode(entreprise.email);
                    emailTextNode.appendChild(email); 
                    emailNode.appendChild(emailTextNode);  
                    infoEntrepriseUl.appendChild(emailNode);
                    
                }

            }).catch(e => alert(e))
        })
    }


    // Array.from(buttons).forEach(function(btn) {
    //     i++;
        
    //         // $.ajax({
    //         //     url:       'list_entreprise_by_categorie'+i,  
    //         //     type:       'POST',
    //         //     data:       {idCategorie: i},  
    //         //     dataType:   'json',  
    //         //     async:      true,  
               
    //         //    success: function(data, status) {  
                 
                  
    //         //       for(i = 0; i < data.length; i++) {  
    //         //          entreprise = data[i];  
                     
    //         //          console.log(entreprise);
                       
    //         //       }  
    //         //    },  
    //         //    error : function(xhr, textStatus, errorThrown) {  
    //         //       alert('Ajax request failed.');  
    //         //    }  
    //         // })
    //     });
    // });
 
}



function filterByCategorie(idCategorie) {
    // console.log("filterByCategorie");
    var listEntreprises = document.getElementsByName('entreprises');
}
