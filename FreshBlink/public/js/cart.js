
document.addEventListener('DOMContentLoaded', () => {
    function updateTotals() {
      let subtotal = 0;
      document.querySelectorAll('tbody tr').forEach(row => {
        const price = parseFloat(row.querySelector('td:nth-child(2)').textContent.replace('$', ''));
        const qty = parseInt(row.querySelector('.quantity').textContent);
        const total = price * qty;
        row.querySelector('.row-total').textContent = `$${total}`;
        subtotal += total;
      });

      document.querySelectorAll('.sm\\:hidden .grid-cols-5').forEach(row => {
        const priceText = row.querySelector('.item-price')?.textContent.replace('$', '');
        const qty = parseInt(row.querySelector('.quantity')?.textContent);
        const price = parseFloat(priceText || 0);
        subtotal += price * qty;
      });

      document.querySelectorAll('.subtotal').forEach(el => el.textContent = `$${subtotal}`);
      document.querySelectorAll('.grand-total').forEach(el => el.textContent = `$${subtotal}`);
    }

    function initButtons(scope) {
      scope.querySelectorAll('.btn-minus').forEach(btn => {
        btn.addEventListener('click', () => {
          const qtyEl = btn.parentElement.querySelector('.quantity');
          let qty = parseInt(qtyEl.textContent);
          if (qty > 1) qtyEl.textContent = --qty;
          updateTotals();
        });
      });

      scope.querySelectorAll('.btn-plus').forEach(btn => {
        btn.addEventListener('click', () => {
          const qtyEl = btn.parentElement.querySelector('.quantity');
          let qty = parseInt(qtyEl.textContent);
          qtyEl.textContent = ++qty;
          updateTotals();
        });
      });

      scope.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', () => {
          const row = btn.closest('tr') || btn.closest('.grid-cols-5');
          if (row) row.remove();
          updateTotals();
        });
      });
    }

    initButtons(document);
    updateTotals();
  });

