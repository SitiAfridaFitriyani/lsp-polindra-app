// Basic

var quill = new Quill('#aplication_description', {
  modules: {
    toolbar: [
      [{ header: [1, 2, false] }],
      ['bold', 'italic', 'underline']
    ]
  },
  placeholder: 'Deskripsi website...',
  theme: 'snow'  // or 'bubble'
});


// With Tooltip

  var quill = new Quill('#quill-tooltip', {
    modules: {
      toolbar: '#toolbar-container'
    },
    placeholder: 'Compose an epic...',
    theme: 'snow'
  });

  // Enable all tooltips
  $('[data-toggle="tooltip"]').tooltip();

  // Can control programmatically too
  $('.ql-italic').mouseover();
  setTimeout(function() {
    $('.ql-italic').mouseout();
  }, 2500);
