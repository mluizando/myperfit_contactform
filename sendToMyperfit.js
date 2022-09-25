function myPerfitSend(event, url, id){
    let form = new FormData(event.target)
    form.append('lists', id)
    let response = async() => {
            let res = await fetch('/myperfit-adduser.php',{
                    method:'POST',
                    body: form
            })
            location = url
    }
    response()
}