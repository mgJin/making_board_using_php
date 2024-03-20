

const logInOutBtn = ()=>{
                form = document.createElement("form");
                form.setAttribute("action","<?= BASE_URL?>/logout");
                form.setAttribute("method","POST");
                document.body.appendChild(form);
                form.submit();
            }
const meBtn = ()=>{
    
        window.location.replace("<?= BASE_URL?>/me");
   
}
            
        
    