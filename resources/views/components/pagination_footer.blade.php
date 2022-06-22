<div class="pagination-footer"
style="
    background-color: #f7f7f7;
    width: 200px;
    margin: 0 auto 50px;
    padding: 5px 15px;
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
    border: 1px solid #aaa;
">
    <button>&#171</button>
    <button onclick="{
        
        var page = document.getElementById('current-page');
        page.value--;

    }">&#8249</button>
    <div>
        <input id="current-page" type="text" style="width: 30px; text-align: center;" value={{$page}} />
        <span>de {{$maxPages}}</span>
    </div>
    <button onclick="{
        
        var page = document.getElementById('current-page');
        page.value++;

    }">&#8250</button>
    <input form={{$formId}} type="submit" value="&#187">
</div>