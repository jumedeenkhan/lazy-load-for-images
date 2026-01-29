document.addEventListener('DOMContentLoaded', function () {
  const nativeCheckbox = document.getElementById('mll-native');
  const thresholdInput = document.getElementById('mll-threshold');
  const thresholdWrap  = document.getElementById('mll-threshold-wrap');

  if (!nativeCheckbox || !thresholdInput || !thresholdWrap) return;

  function toggleThreshold() {
    if (nativeCheckbox.checked) {
      thresholdInput.disabled = true;
      thresholdWrap.classList.add('mll-disabled');
    } else {
      thresholdInput.disabled = false;
      thresholdWrap.classList.remove('mll-disabled');
    }
  }

  nativeCheckbox.addEventListener('change', toggleThreshold);
  toggleThreshold();
});
