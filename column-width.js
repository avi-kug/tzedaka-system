document.querySelectorAll('th').forEach(th => {// הוספת אפשרות לשינוי רוחב עמודה
  const handle = document.createElement('div');
  handle.classList.add('th-resize-handle');
  th.appendChild(handle);

  let startX, startWidth;

  handle.addEventListener('mousedown', (e) => {
    startX = e.pageX;
    startWidth = th.offsetWidth;

    function onMouseMove(e) {
      const newWidth = Math.max(30, startWidth - (e.pageX - startX));

      if (newWidth > 30) { // מינימום רוחב
        th.style.width = newWidth + 'px';
      }
    }

    function onMouseUp() {
      document.removeEventListener('mousemove', onMouseMove);
      document.removeEventListener('mouseup', onMouseUp);
    }

    document.addEventListener('mousemove', onMouseMove);
    document.addEventListener('mouseup', onMouseUp);
  });
});