(function($) {
  
  $(function() {
    $('#data-bulle').DataTable({
      "aLengthMenu": [
        [10, 20, 50, 100, 250],
        [10, 20, 50, 100, 250]
      ],
      "columnDefs": [
              {
                  "targets": [ 0 ],
                  "visible": false,
                  "searchable": false,
              }
          ],
      "iDisplayLength": 10,
      "language": {
        "sProcessing":     "Traitement en cours...",
        "sSearch":         "Recherche",
        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo":           "Affichage des &eacute;l&eacute;ments _START_ &agrave; _END_ sur _TOTAL_",
        "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
        "oPaginate": {
          "sFirst":      "Premier",
          "sPrevious":   "Pr&eacute;c&eacute;dent",
          "sNext":       "Suivant",
          "sLast":       "Dernier"
        },
        "oAria": {
          "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
          "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        },
        "select": {
          "rows": {
            _: "%d lignes séléctionnées",
            0: "Aucune ligne séléctionnée",
            1: "1 ligne séléctionnée"
          }
        }
      }
    });

    $('#data-client').DataTable({
      "aLengthMenu": [
        [10, 20, 50, 100, 250],
        [10, 20, 50, 100, 250]
      ],
      "columnDefs": [
              {
                  "targets": [ 0 ],
                  "visible": false,
                  "searchable": false,
              }
          ],
      "iDisplayLength": 10,
      "language": {
        "sProcessing":     "Traitement en cours...",
        "sSearch":         "Recherche",
        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo":           "Affichage des &eacute;l&eacute;ments _START_ &agrave; _END_ sur _TOTAL_",
        "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
        "oPaginate": {
          "sFirst":      "Premier",
          "sPrevious":   "Pr&eacute;c&eacute;dent",
          "sNext":       "Suivant",
          "sLast":       "Dernier"
        },
        "oAria": {
          "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
          "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        },
        "select": {
          "rows": {
            _: "%d lignes séléctionnées",
            0: "Aucune ligne séléctionnée",
            1: "1 ligne séléctionnée"
          }
        }
      }
    });


    $('#data-besoin').DataTable({
      "aLengthMenu": [
        [10, 20, 50, 100, 250],
        [10, 20, 50, 100, 250]
      ],
      "columnDefs": [
        {
          "targets": [ 0 ],
          "visible": false,
          "searchable": false,
        }
      ],
      "iDisplayLength": 10,
      "language": {
        "sProcessing":     "Traitement en cours...",
        "sSearch":         "Recherche",
        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo":           "Affichage des &eacute;l&eacute;ments _START_ &agrave; _END_ sur _TOTAL_",
        "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
        "oPaginate": {
          "sFirst":      "Premier",
          "sPrevious":   "Pr&eacute;c&eacute;dent",
          "sNext":       "Suivant",
          "sLast":       "Dernier"
        },
        "oAria": {
          "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
          "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        },
        "select": {
          "rows": {
            _: "%d lignes séléctionnées",
            0: "Aucune ligne séléctionnée",
            1: "1 ligne séléctionnée"
          }
        }
      }
    });

    $('.data-besoin').DataTable({
      "aLengthMenu": [
        [10, 20, 50, 100, 250],
        [10, 20, 50, 100, 250]
      ],
      "columnDefs": [
        {
          "targets": [ 0 ],
          "visible": false,
          "searchable": false,
        }
      ],
      "iDisplayLength": 10,
      "language": {
        "sProcessing":     "Traitement en cours...",
        "sSearch":         "Recherche",
        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo":           "Affichage des &eacute;l&eacute;ments _START_ &agrave; _END_ sur _TOTAL_",
        "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
        "oPaginate": {
          "sFirst":      "Premier",
          "sPrevious":   "Pr&eacute;c&eacute;dent",
          "sNext":       "Suivant",
          "sLast":       "Dernier"
        },
        "oAria": {
          "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
          "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        },
        "select": {
          "rows": {
            _: "%d lignes séléctionnées",
            0: "Aucune ligne séléctionnée",
            1: "1 ligne séléctionnée"
          }
        }
      }
    });

    $('#data-sollog').DataTable({
      "aLengthMenu": [
        [10, 20, 50, 100, 250],
        [10, 20, 50, 100, 250]
      ],
      "iDisplayLength": 10,
      "language": {
        "sProcessing":     "Traitement en cours...",
        "sSearch":         "Recherche",
        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo":           "Affichage des &eacute;l&eacute;ments _START_ &agrave; _END_ sur _TOTAL_",
        "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
        "oPaginate": {
          "sFirst":      "Premier",
          "sPrevious":   "Pr&eacute;c&eacute;dent",
          "sNext":       "Suivant",
          "sLast":       "Dernier"
        },
        "oAria": {
          "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
          "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        },
        "select": {
          "rows": {
            _: "%d lignes séléctionnées",
            0: "Aucune ligne séléctionnée",
            1: "1 ligne séléctionnée"
          }
        }
      }
    });

    $('#data-accordeon').DataTable({
      "aLengthMenu": [
        [10, 20, 50, 100, 250],
        [10, 20, 50, 100, 250]
      ],
      "iDisplayLength": 10,
      "language": {
        "sProcessing":     "Traitement en cours...",
        "sSearch":         "Recherche",
        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo":           "Affichage des &eacute;l&eacute;ments _START_ &agrave; _END_ sur _TOTAL_",
        "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
        "oPaginate": {
          "sFirst":      "Premier",
          "sPrevious":   "Pr&eacute;c&eacute;dent",
          "sNext":       "Suivant",
          "sLast":       "Dernier"
        },
        "oAria": {
          "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
          "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        },
        "select": {
          "rows": {
            _: "%d lignes séléctionnées",
            0: "Aucune ligne séléctionnée",
            1: "1 ligne séléctionnée"
          }
        }
      }
    });
    
    $('#data_doc').DataTable( {             
        "order": [[ 0, "desc" ]],
        "autoWidth": false,
        "columnDefs": [
            { width: "0%", "targets": [ 0 ], "visible": false},
            { width: "30%", "targets": [ 1 ] },
            { width: "50%", "targets": [ 2 ] },
            { width: "20%", "targets": [ 3 ] },
        ],
        "language": {
          "sProcessing":     "Traitement en cours...",
          "sSearch":         "Recherche",
          "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
          "sInfo":           "Affichage des &eacute;l&eacute;ments _START_ &agrave; _END_ sur _TOTAL_",
          "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
          "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
          "sInfoPostFix":    "",
          "sLoadingRecords": "Chargement en cours...",
          "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
          "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
          "oPaginate": {
            "sFirst":      "Premier",
            "sPrevious":   "Pr&eacute;c&eacute;dent",
            "sNext":       "Suivant",
            "sLast":       "Dernier"
          },
          "oAria": {
            "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
            "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
          },
          "select": {
            "rows": {
              _: "%d lignes séléctionnées",
              0: "Aucune ligne séléctionnée",
              1: "1 ligne séléctionnée"
          }
        }
      }
    });

    $('#data_img').DataTable( {             
        "order": [[ 0, "desc" ]],
        "autoWidth": false,
        "columnDefs": [
            { width: "0%", "targets": [ 0 ], "visible": false},
            { width: "30%", "targets": [ 1 ] },
            { width: "50%", "targets": [ 2 ] },
            { width: "20%", "targets": [ 3 ] },
        ],
        "language": {
          "sProcessing":     "Traitement en cours...",
          "sSearch":         "Recherche",
          "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
          "sInfo":           "Affichage des &eacute;l&eacute;ments _START_ &agrave; _END_ sur _TOTAL_",
          "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
          "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
          "sInfoPostFix":    "",
          "sLoadingRecords": "Chargement en cours...",
          "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
          "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
          "oPaginate": {
            "sFirst":      "Premier",
            "sPrevious":   "Pr&eacute;c&eacute;dent",
            "sNext":       "Suivant",
            "sLast":       "Dernier"
          },
          "oAria": {
            "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
            "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
          },
          "select": {
            "rows": {
              _: "%d lignes séléctionnées",
              0: "Aucune ligne séléctionnée",
              1: "1 ligne séléctionnée"
          }
        }
      }
    }); 

    $('#data-side').DataTable({
      "aLengthMenu": [
        [10, 20, 50, 100, 250],
        [10, 20, 50, 100, 250]
      ],
      "iDisplayLength": 10,
      "language": {
        "sProcessing":     "Traitement en cours...",
        "sSearch":         "Recherche",
        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo":           "Affichage des &eacute;l&eacute;ments _START_ &agrave; _END_ sur _TOTAL_",
        "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix":    "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
        "oPaginate": {
          "sFirst":      "Premier",
          "sPrevious":   "Pr&eacute;c&eacute;dent",
          "sNext":       "Suivant",
          "sLast":       "Dernier"
        },
        "oAria": {
          "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
          "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        },
        "select": {
          "rows": {
            _: "%d lignes séléctionnées",
            0: "Aucune ligne séléctionnée",
            1: "1 ligne séléctionnée"
          }
        }
      }
    });


    $('#order-listing').each(function() {
      var datatable = $(this);
      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
      search_input.attr('placeholder', 'Recherche');
      search_input.removeClass('form-control-sm');
      // LENGTH - Inline-Form control
      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
      length_sel.removeClass('form-control-sm');
    });
  });
})(jQuery);