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

const input_collection = {
    emfs_level: ['emfs_level'],
    response_direction: ['response_direction'],
    response_quality: ['response_quality'],
    response_quality_addition: ['response_quality_addition'],
    emfs_level_addition: ['emfs_level_addition'],
    response_direction_addition: ['response_direction_addition'],
}

const addNewBtn = document.getElementById('addRow');

addNewBtn.addEventListener('click', function () {
    input_collection.emfs_level.push(`emfs_level${rowCount+1}`);
    input_collection.response_direction.push(`response_direction${rowCount+1}`);
    input_collection.response_quality.push(`response_quality${rowCount+1}`);
    input_collection.response_quality_addition.push(`response_quality_addition${rowCount+1}`);
    input_collection.emfs_level_addition.push(`emfs_level_addition${rowCount+1}`);
    input_collection.response_direction_addition.push(`response_direction_addition${rowCount+1}`);
})

$(document).on('change', '[id^="response_quality"]', function(e) {
    handleChangeBlocks(e.target.id)
});

function handleChangeBlocks(quality_element) {
    const selectedValue = $(`#${quality_element}`).find(":selected").val();
    const isVurulur = selectedValue === 'Vurulur';
    const isYaxsiOrKafi = selectedValue === 'Yaxşı' || selectedValue === 'Kafi';
    const uniqueIndex = quality_element.substring(16, quality_element.length);

    input_collection.response_quality_addition.map(response_quality_addition => {
        $(`#${response_quality_addition}`).css('display', isVurulur ? 'inline-block' : 'none');
    });
    // $('#response_quality_addition').css('display', isVurulur ? 'inline-block' : 'none');
    isVurulur ?  $('div.for_js').removeClass( 'response_quality_addition') : $('div.for_js').addClass( 'response_quality_addition');

    input_collection.emfs_level.map(emfs => {
        if(emfs.substring(10, emfs.length) === uniqueIndex){
            $(`#${emfs}`).prop('disabled', !isVurulur && !isYaxsiOrKafi);
        }
    });
    // $("#emfs_level").prop('disabled', !isVurulur && !isYaxsiOrKafi);

    input_collection.emfs_level_addition.map(emfs_level_addition => {
        $(`#${emfs_level_addition}`).css('display', isVurulur ? 'inline-block' : 'none');
    });
    // $('#emfs_level_addition').css('display', isVurulur ? 'inline-block' : 'none');

    input_collection.response_direction.map(response_direction => {
        if(response_direction.substring(18, response_direction.length) === uniqueIndex){
            $(`#${response_direction}`).prop('disabled', !isVurulur && !isYaxsiOrKafi);
        }
    });
    // $("#response_direction").prop('disabled', !isVurulur && !isYaxsiOrKafi);

    input_collection.response_direction_addition.map(response_direction_addition => {
        $(`#${response_direction_addition}`).css('display', isVurulur ? 'inline-block' : 'none');
    });
    // $('#response_direction_addition').css('display', isVurulur ? 'inline-block' : 'none');
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


