import ajx from './../../shared/index.js';

const tableBank = $('#table-bank');
const formCreateBank = $('#form-create-bank');
const formEditBank = $('#form-edit-bank');
const createTable = (target, data) => {
  target.DataTable({
    data: data,
    lengthChange: false,
    searching: false,
    info: false,
    paging: true,
    pageLength: 5,
    columns: [
      { data: 'name' },
      { 
        data: 'bank',
        render(data) {
          return data.name;
        }
      },
      { data: 'account_number' },
      {
        data: 'id',
        render(data, type, row) {
          return `<a href="/bank_accounts/${data}/edit" class="btn btn-light is-small table-action" data-toggle="tooltip"
          data-placement="top" title="Edit"><img src="assets/images/icons/edit.svg" alt="edit" width="16"></a>`
        },
      },
    ],
    drawCallback: () => {
      $('.table-action[data-toggle="tooltip"]').tooltip();
    }
  })
};

if (tableBank.length > 0) {
  ajx.get('/api/bank_accounts').then((res) => {
    createTable(tableBank, res.bank_accounts.data);
  }).catch(res => console.log(res));
}

if (formCreateBank.length > 0) {
  $('#button-delete').remove();
  formCreateBank.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formCreateBank.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.post('/api/bank_accounts', data).then(res => window.location = '/bank_accounts').catch(res => {
      console.log(res);
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })
}

if (formEditBank.length > 0) {
  const urlArray = window.location.href.split('/');
  const idCategory = urlArray[urlArray.length - 2];
  ajx.get(`/api/bank_accounts/${idCategory}`)
    .then(res => {
      $('#name').val(res.bank_account.name);
      $('#bank_id').val(res.bank_account.bank_id);
      $('#account-number').val(res.bank_account.account_number);
    })
    .catch(res => console.log(res));

  formEditBank.submit((e) => {
    e.preventDefault();
    $('button[type="submit"]').attr('disabled', true);
    const dataForm = formEditBank.serializeArray();
    const data = dataForm.reduce((x, y) => ({ ...x, [y.name]: y.value }), {});
    ajx.put(`/api/bank_accounts/${idCategory}`, data).then(res => window.location = '/bank_accounts').catch(res => {
      console.log(res);
      $('button[type="submit"]').attr('disabled', false);
    });
    return false;
  })

  $('#button-delete').click(() => {
    ajx.delete(`/api/bank_accounts/${idCategory}`).then(res => window.location = '/bank_accounts').catch(res => {
      alert('Cannot delete bank that has been used in transaction')
    });
  })
}
