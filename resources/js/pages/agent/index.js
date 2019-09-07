import ajx from './../../shared/index.js';

const tableAgent = $('#table-agent');
const formCreateAgent = $('#form-create-agent');
const formEditAgent = $('#form-edit-agent');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 5,
    columns: [
      { 
        data: 'agent_group',
        render(data) {
          return data.id === 1 ? 'Agent' : '-';
        }
      },
      { data: 'name' },
      { data: 'phone_number' },
      { data: 'mobile_number' },
      { data: 'district' },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/agents/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};

const errorMessage = (data) => {
  Object.keys(data).map(key => {
    const $parent = $(`#${key}`).closest('.form-group');
    $parent.addClass('is-error');
    $parent[0].querySelector('.invalid-feedback').innerText = data[key][0];
  });
};

if (tableAgent.length > 0) {
  ajx.get('/api/agents').then((res) => {
    createTable(tableAgent, res.agents.data);
  }).catch(res => console.log(res));
}

if (formCreateAgent.length > 0) {
  $('#button-delete').remove();
  formCreateAgent.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formCreateAgent.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/api/agents', data).then(res => window.location = '/agents').catch(res => {
      const errors = res.responseJSON.errors;      
      errorMessage(errors);
      console.log(res);
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })
}

if (formEditAgent.length > 0) {
  const urlArray = window.location.href.split('/');
  const id = urlArray[urlArray.length - 2];
  ajx.get(`/api/agents/${id}`)
    .then((res) => {
      $('#agent_group_id').val(res.agent.agent_group_id);
      $('#name').val(res.agent.name);
      $('#phone_number').val(res.agent.phone_number);
      $('#mobile_number').val(res.agent.mobile_number);
      $('#email').val(res.agent.email);
      $('#address').val(res.agent.address);
      $('#sub_district').val(res.agent.sub_district);
      $('#district').val(res.agent.district);
      $('#city').val(res.agent.city);
      $('#country').val(res.agent.country);
      $('#zip_code').val(res.agent.zip_code);
      $('#contact_name').val(res.agent.contact_name);
      $('#contact_phone_number').val(res.agent.contact_phone_number);
      $('#contact_mobile_number').val(res.agent.contact_mobile_number);
    })
    .catch(res => console.log(res));

  formEditAgent.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formEditAgent.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/api/agents/${id}`, data).then(res => window.location = '/agents').catch(res => {
      const errors = res.responseJSON.errors;      
      errorMessage(errors);
      $('button[type="submit"]').attr('disabled', false);
      console.log(res)
    });
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/agents/${id}`).then(res => window.location = '/agents').catch(res => {
      alert(res.responseJSON.message);
    });
  })
}