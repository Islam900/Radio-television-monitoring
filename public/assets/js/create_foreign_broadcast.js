$('.ui.create_form_dropdown').dropdown({
    clearable: true,
});

$('#frequency_select').dropdown({
    allowAdditions: true,
    clearable: true,
});

$('.frequency_select_cl').dropdown({
    allowAdditions: true,
    clearable: true,
});

const local_input_collection = {
    emfs_level: ['emfs_level'],
    response_direction: ['response_direction'],
    response_quality: ['response_quality'],
    response_quality_addition: ['response_quality_addition'],
    emfs_level_addition: ['emfs_level_addition'],
    response_direction_addition: ['response_direction_addition'],
}

const foreign_input_collection = {
    emfs_level: ['emfs_level'],
    response_direction: ['response_direction'],
    response_quality: ['response_quality'],
    response_quality_addition: ['response_quality_addition'],
    emfs_level_addition: ['emfs_level_addition'],
    response_direction_addition: ['response_direction_addition'],
}

const addNewBtn = document.getElementById('addRow');
const foreignAddNewBtn = document.getElementById('foreign_addRow');

if(addNewBtn){
    addNewBtn.addEventListener('click', function () {
        local_input_collection.emfs_level.push(`emfs_level${rowCount+1}`);
        local_input_collection.response_direction.push(`response_direction${rowCount+1}`);
        local_input_collection.response_quality.push(`response_quality${rowCount+1}`);
        local_input_collection.response_quality_addition.push(`response_quality_addition${rowCount+1}`);
        local_input_collection.emfs_level_addition.push(`emfs_level_addition${rowCount+1}`);
        local_input_collection.response_direction_addition.push(`response_direction_addition${rowCount+1}`);
    })
}

if(foreignAddNewBtn){
    foreignAddNewBtn.addEventListener('click', function () {
        foreign_input_collection.emfs_level.push(`emfs_level${rowCount+1}`);
        foreign_input_collection.response_direction.push(`response_direction${rowCount+1}`);
        foreign_input_collection.response_quality.push(`response_quality${rowCount+1}`);
        foreign_input_collection.response_quality_addition.push(`response_quality_addition${rowCount+1}`);
        foreign_input_collection.emfs_level_addition.push(`emfs_level_addition${rowCount+1}`);
        foreign_input_collection.response_direction_addition.push(`response_direction_addition${rowCount+1}`);
    })
}

$(document).on('change', '[myUniqueItem^="response_quality_local"]', function(e) {
    handleChangeBlocks(e.target.id)
});

$(document).on('change', '[myUniqueItem^="response_quality_foreign"]', function(e) {
    handleChangeBlocks_FOREIGN(e.target.id)
});

function handleChangeBlocks_FOREIGN(quality_element) {
    const selectedValue = $(`#${quality_element}`).find(":selected").val();
    const isVurulur = selectedValue === 'Vurulur';
    const isYaxsiOrKafi = selectedValue === 'Yaxşı' || selectedValue === 'Kafi' || selectedValue === 'Zəif';
    const uniqueIndex = quality_element.substring(16, quality_element.length);

    foreign_input_collection.response_quality_addition.map(response_quality_addition => {
        if(response_quality_addition.substring(25, response_quality_addition.length) === uniqueIndex){
            $(`#${response_quality_addition}`).css('display', isVurulur ? 'inline-block' : 'none');
            isVurulur ? $(`#${response_quality_addition}`).closest('div').removeClass('response_quality_addition') : $(`#${response_quality_addition}`).closest('div').addClass('response_quality_addition');
        }
    });

    foreign_input_collection.emfs_level.map(emfs => {
        if(emfs.substring(10, emfs.length) === uniqueIndex){
            $(`#${emfs}`).prop('disabled', !isVurulur && !isYaxsiOrKafi);
        }
    });

    foreign_input_collection.emfs_level_addition.map(emfs_level_addition => {
        if(emfs_level_addition.substring(19, emfs_level_addition.length) === uniqueIndex){
            $(`#${emfs_level_addition}`).css('display', isVurulur ? 'inline-block' : 'none');
        }
    });

    foreign_input_collection.response_direction.map(response_direction => {
        if(response_direction.substring(18, response_direction.length) === uniqueIndex){
            $(`#${response_direction}`).prop('disabled', !isVurulur && !isYaxsiOrKafi);
        }
    });

    foreign_input_collection.response_direction_addition.map(response_direction_addition => {
        if(response_direction_addition.substring(27, response_direction_addition.length) === uniqueIndex){
            $(`#${response_direction_addition}`).css('display', isVurulur ? 'inline-block' : 'none');
        }
    });
}

function handleChangeBlocks(quality_element) {
    const selectedValue = $(`#${quality_element}`).find(":selected").val();
    const isVurulur = selectedValue === 'Vurulur';
    const isYaxsiOrKafi = selectedValue === 'Yaxşı' || selectedValue === 'Kafi' || selectedValue === 'Zəif';
    const uniqueIndex = quality_element.substring(16, quality_element.length);

    local_input_collection.response_quality_addition.map(response_quality_addition => {
        $(`#${response_quality_addition}`).css('display', isVurulur ? 'inline-block' : 'none');
    });
    isVurulur ?  $('div.for_js').removeClass( 'response_quality_addition') : $('div.for_js').addClass( 'response_quality_addition');

    local_input_collection.emfs_level.map(emfs => {
        if(emfs.substring(10, emfs.length) === uniqueIndex){
            $(`#${emfs}`).prop('disabled', !isVurulur && !isYaxsiOrKafi);
        }
    });

    local_input_collection.emfs_level_addition.map(emfs_level_addition => {
        $(`#${emfs_level_addition}`).css('display', isVurulur ? 'inline-block' : 'none');
    });

    local_input_collection.response_direction.map(response_direction => {
        if(response_direction.substring(18, response_direction.length) === uniqueIndex){
            $(`#${response_direction}`).prop('disabled', !isVurulur && !isYaxsiOrKafi);
        }
    });

    local_input_collection.response_direction_addition.map(response_direction_addition => {
        $(`#${response_direction_addition}`).css('display', isVurulur ? 'inline-block' : 'none');
    });
}

window.addEventListener('DOMContentLoaded', function () {
    const selectedValue = $('#response_quality').find(":selected").val();
    const isVurulur = selectedValue === 'Vurulur';
    const isYaxsiOrKafi = selectedValue === 'Yaxşı' || selectedValue === 'Kafi';

    $('#response_quality_addition').css('display', isVurulur ? 'inline-block' : 'none');
    isVurulur ?  $('div.for_js').removeClass( 'response_quality_addition') : $('div.for_js').addClass( 'response_quality_addition');
    // $("#response_quality_addition").prop('required', isVurulur);

    $("#emfs_level").prop('disabled', !isVurulur && !isYaxsiOrKafi);
    $('#emfs_level_addition').css('display', isVurulur ? 'inline-block' : 'none');
    // $("#emfs_level_addition").prop('required', isVurulur);

    $("#response_direction").prop('disabled', !isVurulur && !isYaxsiOrKafi);
    $('#response_direction_addition').css('display', isVurulur ? 'inline-block' : 'none');
    // $("#response_direction_addition").prop('required', isVurulur);
})


