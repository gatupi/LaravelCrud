var obj = {

};

var months = [
    { name: 'Janeiro', value: 1 }, { name: 'Fevereiro', value: 2 }, { name: 'Março', value: 3 }, { name: 'Abril', value: 4 },
    { name: 'Maio', value: 5 }, { name: 'Junho', value: 6 }, { name: 'Julho', value: 7 }, { name: 'Agosto', value: 8 },
    { name: 'Setembro', value: 9 }, { name: 'Outubro', value: 10 }, { name: 'Novembro', value: 11 }, { name: 'Dezembro', value: 12 }
]; // apenas para comitar

function fillFilterForm() {
    var paramStr = window.location.search;
    var params = new URLSearchParams(paramStr);
    var name_ = document.getElementById('name');
    if (name_) {
        name_.value = params.get('name');
    }
    var activity_ = document.getElementById('activity');
    if (activity_) {
        var activityOptions = activity_.getElementsByTagName('option');
        for (let opt of activityOptions) {
            if (opt.value == params.get('activity')) {
                opt.selected = true;
                break;
            }
        }
    }
    var sex_ = document.getElementById('sex');
    if (sex_) {
        var sexOptions = sex_.getElementsByTagName('option');
        for (let opt of sexOptions) {
            if (opt.value == params.get('sex')) {
                opt.selected = true;
                break;
            }
        }
    }
    var ageFilter = document.getElementById('age_opt');
    if (ageFilter) {
        var ageFilterOptions = ageFilter.getElementsByTagName('option');
        for (let opt of ageFilterOptions) {
            if (opt.value == params.get('age_opt')) {
                opt.selected = true;
                ageFilter.onchange();
                let age1 = document.getElementById('age1');
                let age2 = document.getElementById('age2');
                if (age1)
                    age1.value = params.get('age1');
                if (age2)
                    age2.value = params.get('age2');
                break;
            }
        }
    }
    var birthFilter = document.getElementById('birth_opt');
    if (birthFilter) {
        var birthFilterOptions = birthFilter.getElementsByTagName('option');
        for (let opt of birthFilterOptions) {
            if (opt.value == params.get('birth_opt')) {
                opt.selected = true;
                birthFilter.onchange();
                let birthDate = document.getElementById('birth_date');
                if (birthDate)
                    birthDate.value = params.get('birth_date');
                let birthMonth = document.getElementById('birth_month');
                if (birthMonth) {
                    let options = birthMonth.getElementsByTagName('option');
                    for (let opt of options) {
                        if (opt.value == params.get('birth_month')) {
                            opt.selected = true;
                            break;
                        }
                    }
                }
                let birthYear = document.getElementById('birth_year');
                if (birthYear)
                    birthYear.value = params.get('birth_year');
                let birthdayOptions = document.getElementsByName('birthday_opt');
                if (birthdayOptions?.length > 0) {
                    for (let opt of birthdayOptions) {
                        if (opt.value == params.get('birthday_opt')) {
                            opt.checked = true;
                            break;
                        }
                    }
                }
                break;
            }
        }
    }

}

function onChangeAgeSelect(ageSlct) {
    var val = ageSlct.value;
    var inputs = ageSlct.parentElement.parentElement.getElementsByClassName('cms-slct-filter-el');
    for (let i = inputs.length - 1; i >= 0; i--) {
        inputs[i].remove();
    }
    switch (val) {
        case 'between':
            var input1 = document.createElement('input');
            var and = document.createElement('span');
            input1.type = 'number';
            //input1.value = 18;
            input1.id = input1.name = 'age1';
            input1.classList.add('cms-input-number', 'cms-slct-filter-el');
            and.classList.add('cms-slct-filter-el');
            and.innerText = 'e';
            ageSlct.parentElement.parentElement.append(input1, and);
        case 'greater':
        case 'less':
        case 'equal':
            var input2 = document.createElement('input');
            input2.type = 'number';
            //input2.value = 35;
            input2.id = input2.name = 'age2';
            input2.classList.add('cms-input-number', 'cms-slct-filter-el');
            ageSlct.parentElement.parentElement.append(input2);
            break;
        default:
            break;
    }
}

function onChangeBirthSelect(birthSlct) {

    exec();

    function exec() {
        var val = birthSlct.value;
        var filterBox = birthSlct.parentElement.parentElement;

        clearFilterBox(filterBox);

        switch (val) {
            case 'month-and-year':
                filterBox.append(createMonthSelect());
                filterBox.append(createYearInput());
                break;
            case 'month':
                filterBox.append(createMonthSelect());
                break;
            case 'year':
                filterBox.append(createYearInput());
                break;
            case 'date':
                filterBox.append(createDateInput());
                break;
            case 'birthday':
                var options = createBirthdayOptions();
                for (let o of options)
                    filterBox.append(o);
                break;
            case 'month-and-day':
                var dayInput = document.createElement('input');
                dayInput.type = 'number';
                dayInput.min = 1;
                dayInput.max = 31;
                dayInput.name = dayInput.id = 'birth_day';
                dayInput.value = 1;
                dayInput.classList.add('cms-slct-filter-el');
                dayInput.style.width = '40px';
                filterBox.append(createMonthSelect(), dayInput);
                break;
        }
    }

    function clearFilterBox(filterBox) {
        var inputs = filterBox.getElementsByClassName('cms-slct-filter-el');
        for (let i = inputs.length - 1; i >= 0; i--)
            inputs[i].remove();
    }

    function createMonthSelect() {
        var month_slct = document.createElement('select');
        month_slct.classList.add('cms-slct-filter-el', 'cms-form-select', 'filter-form-input');
        month_slct.id = month_slct.name = 'birth_month';
        for (let m of months) {
            let month_opt = document.createElement('option');
            month_opt.innerText = m.name;
            month_opt.value = m.value;
            month_slct.append(month_opt);
        }
        return month_slct;
    }

    function createYearInput() {
        var input = document.createElement('input');
        input.id = input.name = 'birth_year';
        input.type = 'number';
        input.classList.add('cms-slct-filter-el', 'cms-input-number');
        input.style.width = '55px';
        input.value = 1997;
        input.min = 1950;
        input.max = 2022;
        return input;
    }

    function createDateInput() {
        var input = document.createElement('input');
        input.value = '1997-12-08';
        input.type = 'date';
        input.id = input.name = 'birth_date';
        input.classList.add('cms-slct-filter-el');
        return input;
    }

    function createRadioBox(id, inputId, groupName, labelTxt, value, checked = false) {
        var radio_box = document.createElement('div');
        radio_box.id = id;
        var input = document.createElement('input');
        var label = document.createElement('label');
        input.type = 'radio';
        input.value = value;
        input.checked = checked;
        label.htmlFor = input.id = inputId;
        label.innerText = labelTxt;
        input.name = groupName;
        radio_box.append(input, label);
        return radio_box;
    }

    function createBirthdayOptions() {
        var month_radio_box = createRadioBox('birthday_month_opt_radiobox', 'birthday_month_opt', 'birthday_opt', 'Mês', 'm', true);
        var day_radio_box = createRadioBox('birthday_day_opt_radiobox', 'birthday_day_opt', 'birthday_opt', 'Dia', 'd');
        month_radio_box.classList.add('cms-slct-filter-el');
        day_radio_box.classList.add('cms-slct-filter-el');

        return [month_radio_box, day_radio_box];
    }
} // fim onChangeBirthSelect

// modal

// Get the <span> element that closes the modal
var close_ = document.getElementsByClassName("close")[0];
var modal = document.getElementById('brandModal');

// When the user clicks on <span> (x), close the modal
if (close_) {
    close_.onclick = function () {
        document.getElementById('brandModal').style.display = "none";
    }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function onClickBrand(brandInfo) {
    var modal = document.getElementById('brandModal');
    modal.style.display = 'block';
    document.getElementById('brandNameValue').innerText = brandInfo.name;
    document.getElementById('brandIdValue').innerText = brandInfo.id;
}

// fim modal

var cursorEnd = document.getElementsByClassName('cursor-end');
for (let c of cursorEnd) {
    c.addEventListener('click', (e) => {
        let valueLength = e.target.value.length;
        e.target.selectionStart = e.target.selectionEnd = valueLength;
    });
}

var moneyBr = document.getElementsByClassName('money-br');

for (let mbr of moneyBr) {

    if (obj[mbr.id] == undefined)
        obj[mbr.id] = '0';
    mbr.style.textAlign = 'right';
    mbr.addEventListener('input', (e) => {
        e.target.value = formatMoney(obj[mbr.id]);
    });
    mbr.addEventListener('keydown', (e) => {
        let info = {
            key: e.key,
            code: e.keyCode,
            isNumeric: isNumeric(e.key)
        }
        //console.log(info);
        if (info.isNumeric) {
            obj[mbr.id] = removeLeftZeros(obj[mbr.id] + info.key);
        } else if (info.key == 'Backspace') {
            let val = obj[mbr.id];
            obj[mbr.id] = val.substring(0, val.length - 1);
            if (obj[mbr.id].length == 0)
                obj[mbr.id] = '0';
        }
    });
}

document.getElementById('productCost').addEventListener('input', function () {
    if (getCheckedRadio('applies_margin').checked == 1)
        updateProductPrice();
});
document.getElementById('productMargin').addEventListener('input', function () {
    if (getCheckedRadio('applies_margin').checked == 1)
        updateProductPrice();
})
document.getElementById('productFixedPrice').addEventListener('input', function () {
    if (getCheckedRadio('applies_margin').checked == 0)
        updateProductPrice();
})

function formatMoney(cents) {
    if (cents == null || cents == undefined || cents.length == 0)
        return "R$0,00";
    if (cents.length <= 2)
        return `R$0,${cents.padStart(2, '0')}`;
    return `R$${cents.substring(0, cents.length - 2)},${cents.substring(cents.length - 2)}`;
}

function isNumeric(chr) {
    const numeric = '0123456789';
    for (let n of numeric)
        if (chr == n)
            return true;
    return false;
}

function removeLeftZeros(numericStr) {
    if (numericStr) {
        let index = 0;
        while (index < numericStr.length && numericStr[index] == '0')
            index++;
        return index == numericStr.length ? '0' : numericStr.substring(index);
    }
    return null;
}

function getCheckedRadio(name) {
    let radio = document.getElementsByName(name);
    if (radio) {
        for (let opt of radio)
            if (opt.checked)
                return { radio: name, checked: opt.value };
    }
    return null;
}

var marginOptions = document.getElementsByName('applies_margin');
for (let opt of marginOptions) {
    opt.addEventListener('change', function () {
        updateProductPrice();
        // console.log(obj);
    });
}

// margin

function formatPercentage(percentage) {
    if (percentage) {
        if (percentage.length < 2)
            return '0,' + percentage + '%';
        return `${percentage.substring(0, percentage.length - 1)},${percentage.substring(percentage.length - 1)}%`;
    }
}

var percentage = document.getElementsByClassName('percentage');
for (let p of percentage) {
    p.style.textAlign = 'right';
    if (!obj[p.id])
        obj[p.id] = '0';
    p.addEventListener('keydown', (e) => {
        if (isNumeric(e.key)) {
            obj[p.id] = removeLeftZeros(obj[p.id] + e.key);
        } else if (e.key == 'Backspace') {
            let val = obj[p.id];
            obj[p.id] = val.substring(0, val.length - 1);
            if (obj[p.id].length == 0)
                obj[p.id] = '0';
        }
    });
    p.addEventListener('input', (e) => {
        e.target.value = formatPercentage(obj[p.id]);
    });
}

function calculatePrice() {
    let cost = parseFloat(obj.productCost) / 100;
    let margin = parseFloat(obj.productMargin) / 10;
    let price = (1 + margin / 100) * cost;
    obj.productPrice = Math.trunc(Math.round(price * 100)).toString();
    // console.log({cost, margin, price});
    // console.log(obj);
}

function updateProductPrice() {

    let el = document.getElementById('productPrice');
    if (el) {
        let checked = getCheckedRadio('applies_margin').checked;
        // console.log(checked);
        if (checked == 0)
            obj.productPrice = obj.productFixedPrice;
        else if (checked == 1)
            calculatePrice();
        el.value = formatMoney(obj.productPrice);
    }
}

function viewProductImage() {
    let img = document.getElementById('productImage');
    img.onload = () => {
        URL.revokeObjectURL(img.src);
    }
    img.src = URL.createObjectURL(document.getElementById('uploadProductImg').files[0]);
    let parent = img.parentElement;
    if (parent.style.display == 'none')
        parent.style.display = 'block';
    else
        parent.style.display = 'none';
}

function uploadProductImage() {
    let imgName = document.getElementById('imageName');
    imgName.innerText = document.getElementById('uploadProductImg').files[0].name;
    let icons = document.getElementsByClassName('img-icon');
    for (let i of icons) {
        if (i.style.display == 'none')
            i.style.display = 'initial';
    }
    document.getElementById('productImageBox').style.display = 'none';
}

function deleteProductImage() {
    let productImg = document.getElementById('uploadProductImg');
    productImg.value = '';
    let icons = document.getElementsByClassName('img-icon');
    for (let i of icons)
        i.style.display = 'none';
    document.getElementById('imageName').innerText = 'Nenhuma imagem';
    document.getElementById('productImageBox').style.display = 'none';
}

//fim margin


fillFilterForm();