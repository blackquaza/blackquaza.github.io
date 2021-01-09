function preview() {
    name = document.getElementsByName("Name")[0].value;
    url = document.getElementsByName("URL")[0].value;
    desc = document.getElementsByName("Description")[0].value;
    price = document.getElementsByName("Price")[0].value;
    stock = document.getElementsByName("Stock")[0].value;

    if (url.length == 0) {
        url = "https://cisweb.ufv.ca/~300083663/cis245/img/placeholder.png";
    }

    if (name.length != 0) {
        document.getElementById("previewName").innerHTML = name;
        document.getElementById("previewURL").src = url;
        document.getElementById("previewDesc").innerHTML = desc;
        
        other = `Price: ${price.toString()}<br>Stock: ${stock.toString()}<br>Number Sold: ??`;
        document.getElementById("previewOther").innerHTML = other;

        document.getElementById("previewCard").style = "";
    }
}