var months = [
    { name: 'Janeiro', value: 1 }, { name: 'Fevereiro', value: 2 }, { name: 'Março', value: 3 }, { name: 'Abril', value: 4 },
    { name: 'Maio', value: 5 }, { name: 'Junho', value: 6 }, { name: 'Julho', value: 7 }, { name: 'Agosto', value: 8 },
    { name: 'Setembro', value: 9 }, { name: 'Outubro', value: 10 }, { name: 'Novembro', value: 11 }, { name: 'Dezembro', value: 12 }
]; // apenas para comitar

function fillFilterForm() {
    var paramStr = window.location.search;
    var params = new URLSearchParams(paramStr);
    document.getElementById('name').value = params.get('name');
    var activityOptions = document.getElementById('activity').getElementsByTagName('option');
    for (let opt of activityOptions) {
        if (opt.value == params.get('activity')) {
            opt.selected = true;
            break;
        }
    }
    var sexOptions = document.getElementById('sex').getElementsByTagName('option');
    for (let opt of sexOptions) {
        if (opt.value == params.get('sex')) {
            opt.selected = true;
            break;
        }
    }
    var ageFilter = document.getElementById('age_opt');
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
    var birthFilter = document.getElementById('birth_opt');
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
var close = document.getElementsByClassName("close")[0];
var modal = document.getElementById('brandModal');

// When the user clicks on <span> (x), close the modal
close.onclick = function() {
    document.getElementById('brandModal').style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
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

fillFilterForm();