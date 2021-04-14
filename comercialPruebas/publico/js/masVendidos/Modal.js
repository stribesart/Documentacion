export function Modal(id, title, modalBody, type = 0, sizeClass = "modal-xl") {
    const $modal = document.createElement('div');
    $modal.classList.add('modal');
    $modal.classList.add('fade');
    $modal.id = id;
    $modal.tabIndex = -1;
    $modal.setAttribute('role', 'dialog');
    $modal.setAttribute('aria-labelledby', 'modal-default');
    $modal.setAttribute('aria-modal', 'true');

    const $modalDialog = document.createElement('div');
    $modalDialog.classList.add('modal-dialog');
    $modalDialog.classList.add('modal-dialog-centered');
    $modalDialog.classList.add('modal-dialog-scrollable');
    $modalDialog.classList.add(sizeClass);
    $modalDialog.setAttribute('role', 'document');

    const $modalContent = document.createElement('div');

    $modalContent.classList.add('modal-content');

    const $modalHeader = document.createElement('div');

    $modalHeader.classList.add('modal-header');
    $modalHeader.id = `header-${id}`;

    $modalHeader.innerHTML = `
          <h3 class="modal-title" id="exampleModalLabel">${title}</h3>
  `;

    const $modalBody = document.createElement('div');

    $modalBody.classList.add('modal-body');
    $modalBody.appendChild(modalBody);
    $modalBody.id = `modal-body-${id}`;
    const $modalFooter = document.createElement('div');

    $modalFooter.classList.add('modal-footer');
    if (type === 0) {
        $modalFooter.innerHTML = `
          <button type="button" class="btn btn-secondary  ml-auto" data-bs-dismiss="modal" .
          ="close-button">Close</button>
      `;
    }else if(type === 1){
      $modalFooter.innerHTML = `
        <button type="button" id="modal-guardar" class="btn btn-secondary  ml-auto" >Guardar</button>
        <button type="button" class="btn btn-secondary  ml-auto" data-bs-dismiss="modal">Close</button>
      `;
    }

    $modalContent.appendChild($modalHeader);
    $modalContent.appendChild($modalBody);
    $modalContent.appendChild($modalFooter);
    $modalDialog.appendChild($modalContent);
    $modal.appendChild($modalDialog);

    return $modal;
}