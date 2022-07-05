var httpRequest;

document.getElementById('searchCategory').addEventListener('click', makeRequest);

function makeRequest() {
    httpRequest = new XMLHttpRequest();

    if (!httpRequest) {
        alert('Giving up :( Cannot create an XMLHTTP instance');
        return false;
    }

    httpRequest.onreadystatechange = alertContents;
    httpRequest.open('GET', 'http://localhost:8000/api/product-categories');
    httpRequest.send();
}

function alertContents() {
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
        if (httpRequest.status === 200) {
            let data = JSON.parse(httpRequest.responseText);
            //console.log(data);
            document.getElementsByTagName('main')[0].append(createTreeNode(data));
        } else {
            alert('There was a problem with the request.');
        }
    }

    function createTreeNode(node) {
        let ul = document.createElement('ul');
        let item = document.createElement('li');
        let title = document.createElement('span');
        title.innerText = node.name;
        item.append(title);
        if (node.children) {
            for(let c of node.children)
            item.append(createTreeNode(c));
        }
        ul.append(item);
        return ul;
    }
}