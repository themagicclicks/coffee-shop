document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, []);
    
    document.querySelectorAll('.pell').forEach(function (editorElement, index) {
        pell.init({
            element: editorElement,
            onChange: function (html) {
                const contentElement = editorElement.querySelector('.pell-content');
                const className = Array.from(contentElement.classList).find(c =>
                    /^.+-.+-.+-\d+$/.test(c)
                );
                if (className) {
                    let hiddenTextarea = document.querySelector(`textarea[name="${className}"]`);
                    if (!hiddenTextarea) {
                        hiddenTextarea = document.createElement('textarea');
                        hiddenTextarea.name = className;
                        hiddenTextarea.style.display = 'none';
                        editorElement.appendChild(hiddenTextarea);
                    }
                    hiddenTextarea.value = html;
                }
            },
            actions: [
                "bold", "italic", "underline", "strikethrough", "heading1", "heading2",
                "paragraph", "quote", "olist", "ulist", "code", "line", "link",
                {
                    name: 'image',
                    icon: '<b>🖼️</b>',
                    title: 'Insert Image',
                    result: () => {
                        const thisEditor = editorElement.querySelector('.pell-content');
                        openImageBrowser((imageUrl) => {
                            const img = document.createElement('img');
                            img.src = imageUrl;
                            thisEditor.appendChild(img);
                        });
                    }
                },
                {
                  name: 'template',
                  icon: '<b>📄</b>',
                  title: 'Insert Template',
                  result: () => {
                    const editor = document.activeElement.closest('.pell').querySelector('.pell-content');
                    openTemplateBrowser((html) => {
                      editor.insertAdjacentHTML('beforeend', html);
                    });
                  }
                },
                {
                    name: 'html',
                    icon: '<i class="material-icons">code</i>',
                    title: 'Toggle HTML',
                    result: () => {
                      toggleHTMLMode(editorElement);
                    }
                }

            ]
        });
    });

    // Find all Pell editors on the page
    const editors = document.querySelectorAll('.pell');

    editors.forEach(function (editorElement) {
        const hiddenInput = editorElement.querySelector('.edit-content');
        const contentDiv = editorElement.querySelector('.pell-content');

        if (hiddenInput && contentDiv) {
            const rawHtml = hiddenInput.value;
            const decodedHtml = decodeHTMLEntities(rawHtml);
            contentDiv.innerHTML = decodedHtml;
        }
    });
    document.body.addEventListener("click", function (event) {
        if (event.target.matches("button[type='submit'], input[type='submit']")) {
            event.preventDefault();
            setPell();
    
            let submitButton = event.target;
            let form = submitButton.closest("form");
            if (!form) return;
    
            let actionURL = form.getAttribute("action");
            if (!actionURL) {
                console.error("No action URL found for the form.");
                return;
            }
    
            let formData = new FormData(form);
    
            // HTML encode string fields
            for (let [key, value] of formData.entries()) {
                if ( key == 'input_field_input') {  
                    // Base64 encode the value
                    let encoded = btoa(unescape(encodeURIComponent(value))); // handle Unicode
                    formData.set(key, '__ENCODED__' + encoded); // add marker prefix
                }
                if ( key.indexOf('Content_Editable_Template')>=0) { 
                    // Base64 encode the value
                    let encoded = btoa(unescape(encodeURIComponent(value))); // handle Unicode
                    formData.set(key, '__ENCODED__' + encoded); // add marker prefix
                }
                if ( key.indexOf('template_html')>=0) { 
                    // Base64 encode the value
                    let encoded = btoa(unescape(encodeURIComponent(value))); // handle Unicode
                    formData.set(key, '__ENCODED__' + encoded); // add marker prefix
                }
                if ( key.indexOf('preview_template_html')>=0) { 
                    // Base64 encode the value
                    let encoded = btoa(unescape(encodeURIComponent(value))); // handle Unicode
                    formData.set(key, '__ENCODED__' + encoded); // add marker prefix
                }
            }
    
            let xhr = new XMLHttpRequest();
            xhr.open("POST", actionURL, true);
    
            xhr.onload = function () {
                if (xhr.status === 200) {
                    try {
                        let response = JSON.parse(xhr.responseText);
                        if (response.status === "success") {
                            window.history.back();
                        } else {
                            alert(response.message || "An error occurred.");
                        }
                    } catch (e) {
                        console.error("Failed to parse response JSON:", xhr.responseText);
                        alert("Unexpected response from server.");
                    }
                } else {
                    console.error("Error submitting form:", xhr.statusText);
                    alert("Form submission failed. Please try again.");
                }
            };
    
            xhr.onerror = function () {
                console.error("Network error while submitting form.");
                alert("Network error. Please check your connection.");
            };
    
            xhr.send(formData);
        }
    });

    document.querySelectorAll('a.delete').forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
    
            const confirmDelete = confirm('Are you sure you want to delete this item?');
            if (!confirmDelete) return;
    
            const url = this.href;
    
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Item deleted successfully.");
    
                        // Optionally remove the item's row or parent element
                        // This assumes the delete button is inside a row you want to remove
                        const row = link.closest('tr'); // or adjust selector if needed
                        if (row) row.remove();
    
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(error => {
                    console.error('Deletion error:', error);
                    alert("An error occurred while deleting the item.");
                });
        });
    });
    document.querySelectorAll('.select-wrapper').forEach(wrapper => {
      const prev = wrapper.previousElementSibling;
      if (prev && prev.tagName.toLowerCase() === 'label') {
        prev.style.display = 'none';
      }
    });

});
window.addEventListener("load", function () {
    document.body.style.opacity = "1";
    
    
});
function setPell() {
    document.querySelectorAll('.pell').forEach(function (editorWrapper) {
        const editorDiv = editorWrapper.querySelector('.pell-content');
        if (!editorDiv) return;

        const parentDiv = editorWrapper;
        if (!parentDiv) return;

        const className = Array.from(parentDiv.classList).find(c =>
            /^[\w]+-wysiwyg-pell-string-\d+$/.test(c)
        );
        if (!className) return;

        let hiddenTextarea = document.querySelector('textarea[name="' + className + '"]');
        if (!hiddenTextarea) {
            hiddenTextarea = document.createElement('textarea');
            hiddenTextarea.name = className;
            hiddenTextarea.style.display = 'none';
            parentDiv.appendChild(hiddenTextarea);
        }

        // Check if we're in HTML mode
        const htmlTextarea = editorWrapper.querySelector('.pell-html-mode');
        if (htmlTextarea) {
            hiddenTextarea.value = htmlTextarea.value;
        } else {
            hiddenTextarea.value = editorDiv.innerHTML;
        }
    });
}


function decodeHTMLEntities(str) {
    const txt = document.createElement("textarea");
    txt.innerHTML = str;
    return txt.value;
}
function openImageBrowser(callback) {
  const modal = document.createElement('div');

  // Get images from the existing hidden container
  const imageContainer = document.querySelector('.images-browse-list');
  if (!imageContainer) {
    alert('No images found.');
    return;
  }

  // Clone the content and replace data-src with src
  const imageListHtml = imageContainer.innerHTML.replace(/data-src=/g, 'src=');

  modal.innerHTML = `
    <div class="modal-overlay" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);display:flex;justify-content:center;align-items:center;z-index:9999;">
      <div class="modal-content" style="background:#fff;padding:20px;border-radius:8px;max-height:80vh;overflow:auto;">
        <h3>Select an Image</h3>
        <div class="image-list" style="display:flex;flex-wrap:wrap;gap:10px;">
          ${imageListHtml}
        </div>
        <button onclick="closeModal()" style="margin-top:15px;">Close</button>
      </div>
    </div>
  `;

  document.body.appendChild(modal);

  // Fix image click behavior (rebinding events)
  const images = modal.querySelectorAll('img');
  images.forEach(img => {
    img.onclick = () => {
      callback(img.src);
      closeModal();
    };
  });

  window.closeModal = function () {
    modal.remove();
  };
}
function openTemplateBrowser(callback) {
  const templates = document.querySelectorAll('.templates-browse-list li');

  const modal = document.createElement('div');
  modal.classList.add('modal-overlay');

  let thumbsHtml = '';

  Array.from(templates).forEach((t, i) => {
    const previewDiv = t.querySelector('div'); // first div should be the scaled preview
    if (!previewDiv) return; // skip if structure is off

    const nameDiv = previewDiv.nextElementSibling;
    const name = nameDiv?.textContent?.trim() || t.getAttribute('title') || `Template ${i + 1}`;

    thumbsHtml += `
      <div class="template-thumb" data-index="${i}"
           style="flex: 1 0 30%; border: 1px solid #ddd; padding: 10px; cursor: pointer;">
        ${previewDiv.outerHTML}
        <div class="template-label" style="margin-top: 5px; text-align: center; font-size: 0.9em;">${name}</div>
      </div>
    `;
  });

  modal.innerHTML = `
    <div class="modal-content" style="max-width: 900px; background: white; padding: 20px;">
      <h4>Select a Template</h4>
      <div class="template-grid" style="display: flex; flex-wrap: wrap; gap: 10px;">
        ${thumbsHtml}
      </div>
      <div id="templatePreview" style="margin: 20px 0; border: 1px solid #ccc; padding: 15px; min-height: 100px;">
        <em>Select a template to preview it here...</em>
      </div>
      <div class="right-align" style="margin-top: 10px;">
        <button class="btn modal-close grey lighten-1" onclick="closeModal()">Cancel</button>
        <button class="btn blue" id="insertTemplateBtn" disabled>Insert</button>
      </div>
    </div>
  `;

  document.body.appendChild(modal);

  const preview = modal.querySelector('#templatePreview');
  const insertBtn = modal.querySelector('#insertTemplateBtn');
  const thumbs = modal.querySelectorAll('.template-thumb');

  let selectedHtml = null;

  thumbs.forEach(thumb => {
    thumb.addEventListener('click', () => {
      thumbs.forEach(t => t.classList.remove('selected'));
      thumb.classList.add('selected');

      const scaledDiv = thumb.querySelector('div');
      if (scaledDiv) {
        const fullClone = scaledDiv.cloneNode(true);
        fullClone.style.transform = 'scale(1)';
        fullClone.style.width = '100%';
        fullClone.style.pointerEvents = 'auto';

        preview.innerHTML = '';
        preview.appendChild(fullClone);
        selectedHtml = fullClone.outerHTML;

        insertBtn.disabled = false;
      }
    });
  });

  insertBtn.addEventListener('click', () => {
    if (selectedHtml) {
      callback(selectedHtml);
      closeModal();
    }
  });

  window.closeModal = function () {
    modal.remove();
  };

  // Modal styling
  modal.style.position = 'fixed';
  modal.style.top = '0';
  modal.style.left = '0';
  modal.style.width = '100vw';
  modal.style.height = '100vh';
  modal.style.background = 'rgba(0,0,0,0.6)';
  modal.style.zIndex = '999';
  modal.style.display = 'flex';
  modal.style.alignItems = 'center';
  modal.style.justifyContent = 'center';
}


function toggleHTMLMode(editorElement) {
  const content = editorElement.querySelector('.pell-content');

  if (content.style.display !== 'none') {
    // Switch to HTML mode
    const textarea = document.createElement('textarea');
    textarea.className = 'pell-html-mode';
    textarea.style.width = '100%';
    textarea.style.minHeight = '200px';
    textarea.value = content.innerHTML;
    content.style.display = 'none';
    content.parentNode.insertBefore(textarea, content.nextSibling);
  } else {
    // Switch back to WYSIWYG mode
    const textarea = editorElement.querySelector('.pell-html-mode');
    content.innerHTML = textarea.value;
    textarea.remove();
    content.style.display = '';
  }
}
function safeBase64Decode(base64) {
  const binary = atob(base64);
  const len = binary.length;
  const bytes = new Uint8Array(len);
  for (let i = 0; i < len; i++) {
    bytes[i] = binary.charCodeAt(i);
  }

  try {
    return new TextDecoder().decode(bytes);
  } catch (e) {
    console.error('Decoding failed:', e);
    return '<div style="color:red;">Preview not available (invalid characters)</div>';
  }
}
function unescapeHtml(html) {
  const div = document.createElement('div');
  div.innerHTML = html;
  return div.textContent || div.innerText || "";
}