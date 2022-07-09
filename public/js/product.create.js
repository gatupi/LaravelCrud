var categoryTree;
var categoryId;

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
                categoryTree = JSON.parse(httpRequest.responseText);
                let modal = document.querySelector('#categoryModal');
                modal.querySelector('.cms-modal-content').append(createTree('categoriesTree', categoryTree));
            } else {
                alert('There was a problem with the request.');
            }
        }
    }
}

function createTreeNodeTitle(name, tree) {
    let title = document.createElement('span');
    title.classList.add('tree-title');
    title.textContent = name;
    addClickEventToTreeNodeTitle(title, tree);

    return title;
}

function getSelectedFromTree(tree) {

    if (typeof (tree) == 'string') {
        tree = document.querySelector(tree);
        if (!tree)
            return;
    }

    let ids = [];
    let selected = tree.getElementsByClassName('cms-tree-element-selected');
    for (let s of selected)
        ids.push(parseInt(s.parentElement.dataset.id));

    return ids;
}

function addClickEventToTreeNodeTitle(treeNodeTitle, tree) {
    treeNodeTitle.addEventListener('click', function () {
        if ([...tree.classList].includes('cms-tree-single-select'))
            deselectTreeElements(tree);
        treeNodeTitle.classList.toggle('cms-tree-element-selected');
        let selected = getSelectedFromTree(tree);
        if (selected) {
            let selectedBox = tree.parentElement.parentElement.parentElement.querySelector('.cms-modal-selected-option-box');
            selectedBox.classList.toggle('cms-selected-box-hidden', !selected.length);
            
            let list = selectedBox.querySelector('.cms-modal-selected-option-content').querySelector('ul');
            list.innerHTML = '';
            for(let sel of selected) {
                let li = document.createElement('li');
                li.textContent = findCategoryBydId(sel).path;
                list.append(li);
            }
        }
    });
}

function addClickEventToTreeNodeArrow(treeNodeArrow) {
    treeNodeArrow.addEventListener('click', function () {
        treeNodeArrow.classList.toggle('tree-arrow');
        treeNodeArrow.classList.toggle('tree-arrow-down');
        if ([...treeNodeArrow.parentElement.classList].includes('has-children')) {
            treeNodeArrow.parentElement.querySelector('ul').classList.toggle('tree-node-hidden');
        }
    });
}

function deselectTreeElements(tree) {
    let className = 'cms-tree-element-selected';
    let selected = tree.getElementsByClassName(className);
    for (let s of selected)
        s.classList.remove(className);
}

function createTreeNodeArrow() {
    let arrow = document.createElement('span');
    arrow.classList.add('tree-arrow');
    arrow.textContent = '\u25B6';
    addClickEventToTreeNodeArrow(arrow);

    return arrow;
}

function createNode(node, tree) {
    let nodeElement = document.createElement('li');
    nodeElement.dataset.id = node.id;
    nodeElement.append(createTreeNodeArrow(), createTreeNodeTitle(node.name, tree));
    nodeElement.classList.add('tree-node');

    return nodeElement;
}

function createTree(htmlId, treeContent, multiSelect = false) {
    let tree = document.createElement('ul');
    tree.classList.add('cms-tree', `cms-tree-${(multiSelect ? 'multi' : 'single')}-select`);
    tree.id = htmlId;
    tree.append(createTreeNodesRecursively(treeContent, tree));

    return tree;
}

function createTreeNodesRecursively(node, tree) {

    let nodeElement = createNode(node, tree);

    if (node.children && node.children.length > 0) {
        nodeElement.classList.add('has-children');
        let list = document.createElement('ul');
        list.classList.add('tree-node-hidden');
        nodeElement.append(list);
        for (let child of node.children)
            list.append(createTreeNodesRecursively(child, tree));
    }

    return nodeElement;
}

function findCategoryBydId(id) {
    return findCategoryBydIdRecursively(id, [categoryTree]);
}

function findCategoryBydIdRecursively(id, nodes) {
    if (nodes && nodes.length > 0) {
        for (let n of nodes) {
            if (n.children) {
                let r = findCategoryBydIdRecursively(id, n.children);
                if (r != null) {
                    r.path = `${n.name} > ${r.path}`;
                    return r;
                }
            }
            if (n.id === id)
                return { node: n, path: n.name };
        }
    }
    return null;
}

document.querySelector('#searchCategory').addEventListener('click', function () {
    openModal(document.querySelector('#categoryModal'));
    loadCategoriesToModal();
});

document.querySelector('#searchBrand').addEventListener('click', function () {
    openModal(document.querySelector('#brandModal'));
});

document.querySelector('#categoryOkButton').addEventListener('click', e => {
    let tree = document.querySelector('#categoriesTree');
    let modal = tree.parentElement.parentElement.parentElement;
    removeModalContent(modal);
    modal.classList.toggle('cms-closed-modal');
    categoryId = getSelectedFromTree(tree)[0];

    let input = document.querySelector('#productCategory');
    input.value = findCategoryBydId(categoryId).node.name;
    input.dataset.categoryId = categoryId;
});