@extends('layouts.main', ['title'=>'Cadastro de Produto', 'create'=>false])
@section('content')

<form id="productRegisterForm" class="cms-register-form product-register-form" action="">

    <div class="cms-label-input-box" style="width: 100%;">
        <input id="productDescription" name="description" type="text">
        <label for="productDescription">Descrição</label>
    </div>

    <div style="display: flex; margin-top: 10px;">
        <div>
            <div style="display:inline-flex; align-items: flex-end;">
                <div class="cms-label-input-box" style="width: 250px;">
                    <input class="cms-disabled-input" id="productCategory" name="" type="text" disabled>
                    <label for="productCategory">Categoria</label>
                </div>
                <div style="height: 16pt; padding:2px; margin-left: 5px;">
                    <img id="searchCategory" class="cms-search-icon" style="height: 100%;" src="{{asset('img/search-icon.png')}}" alt="search-icon"
                        onclick="{document.getElementById('productCategory').value = 'Camisetas de futebol'}">
                </div>
            </div>
    
            <div style="display:inline-flex; align-items: flex-end; margin-left: 10px;">
                <div class="cms-label-input-box" style="width: 250px;">
                    <input class="cms-disabled-input" id="productBrand" name="" type="text" disabled>
                    <label for="productCategory">Marca</label>
                </div>
                <div style="height: 16pt; padding:2px; margin-left: 5px;">
                    <img class="cms-search-icon" style="height: 100%;" src="{{asset('img/search-icon.png')}}" alt="search-icon"
                        onclick="{document.getElementById('productBrand').value = 'Nike Corinthians'}">
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex; margin-top: 10px;">
        <div class="cms-label-input-box">
            <input id="productCost" class="money-br cursor-end" name="cost" type="text" value="R$0,00">
            <label for="productCost">Custo</label>
        </div>

        <div class="cms-label-input-box" style="width: 100px; margin-left: 10px;">
            <input id="productMargin" class="percentage cursor-end" name="cost" type="text" value="0,0%">
            <label for="productMargin">Margem</label>
        </div>

        <div class="cms-label-input-box" style="margin-left: 10px;">
            <input id="productFixedPrice" class="money-br cursor-end" name="cost" type="text" value="R$0,00">
            <label for="productFixedPrice">Preço fixo</label>
        </div>

        <div style="display:flex; flex-direction:column; justify-content:end; margin-left: 10px;">
            <div>
                <input id="appliesMargin" name="applies_margin" value="1" type="radio" checked>
                <label for="appliesMargin">Aplica margem</label>
            </div>
            <div>
                <input id="appliesFixedPrice" name="applies_margin" value="0" type="radio">
                <label for="appliesFixedPrice">Preço fixo</label>
            </div>
        </div>

        <div class="cms-label-input-box" style="margin-left: 10px;">
            <input style="text-align: right;" class="cms-disabled-input" id="productPrice" name="cost" type="text" value="R$0,00" disabled>
            <label for="productPrice">Preço final</label>
        </div>
    </div>

    <div style="margin-top: 10px; display: flex;">
        <div style="display: flex; align-items: center;">
            <input style="display: none;" id="uploadProductImg" type="file" accept="image/*" onchange="uploadProductImage()">
            <label class="upload-file" for="uploadProductImg" style="background: #f5f5f5; padding: 5px; border: 1px solid black; border-radius: 5px;">Carregar imagem</label>
            <span style="margin-left: 10px;" id="imageName">Nenhuma imagem</span>
            <img id="deleteImgIcon" class="img-icon" style="height: 1em; margin-left: 10px; display: none;" src="{{asset('img/delete-icon.png')}}" alt="delete icon"
                onclick="deleteProductImage()">
            <img id="viewImgIcon" class="img-icon" style="height: 1em; margin-left: 10px; display: none;" src="{{asset('img/view-icon-2.png')}}" alt="view icon"
                onclick="viewProductImage()">
        </div>
    </div>

    <div id="productImageBox" style="display: none; height: 120px; margin-top: 10px;">
        <img style="height: calc(100% - 2px); border: 1px solid black; border-radius: 10px;" id="productImage" src="#" alt="product image">
    </div>
</form>

@endsection