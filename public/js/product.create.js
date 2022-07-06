function loadCategoriesToModal() {
    let httpRequest = new XMLHttpRequest();

    if (!httpRequest) {
        alert('Giving up :( Cannot create an XMLHTTP instance');
        return false;
    }

    httpRequest.onreadystatechange = load;
    httpRequest.open('GET', 'http://localhost:8000/api/product-categories');
    httpRequest.send();

    function load() {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                let data = JSON.parse(httpRequest.responseText);
                //console.log(data);
                let modal = document.querySelector('#categoryModal');
                modal.querySelector('.cms-modal-content').append(createCategoryTree(data));
            } else {
                alert('There was a problem with the request.');
            }
        }
    }

    function createCategoryTree(node) {
        let ul = document.createElement('ul');
        let item = document.createElement('li');
        let arrow = document.createElement('span');
        let title = document.createElement('span');
        title.dataset.categoryId = node.id;
        title.addEventListener('click', e => {
            chosenCategoryId = e.target.dataset.categoryId;
            console.log(chosenCategoryId);
            let selected = document.getElementsByClassName('cat-selected');
            for (let s of selected)
                s.classList.toggle('cat-selected');
            e.target.classList.toggle('cat-selected');
        });
        arrow.innerText = '\u25B6';
        arrow.classList.add('tree-arrow');
        title.innerText = node.name;
        title.classList.add('category-name');
        item.append(arrow, title);
        if (node.children) {
            arrow.classList.add('visible');
            arrow.addEventListener('click', e => {
                if ([...e.target.classList].includes('tree-arrow')) {
                    e.target.classList.remove('tree-arrow');
                    e.target.classList.add('tree-arrow-down');
                } else if ([...e.target.classList].includes('tree-arrow-down')) {
                    e.target.classList.remove('tree-arrow-down');
                    e.target.classList.add('tree-arrow');
                }
                let parent = e.target.parentElement;
                if (parent.children.length > 2) {
                    for (let i = 2; i < parent.children.length; i++) {
                        parent.children[i].classList.toggle('active');
                    }
                }
            });
            ul.classList.add('has-children');
            for (let c of node.children)
                item.append(createCategoryTree(c));
        }
        ul.append(item);
        if (node.parent_id != null)
            ul.classList.add('nested');
        else
            ul.classList.add('categoryTree');
        return ul;
    }
}

document.getElementById('searchCategory').addEventListener('click', loadCategoriesToModal);