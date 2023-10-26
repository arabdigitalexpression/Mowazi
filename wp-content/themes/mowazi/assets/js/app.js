function toggleExpand(elem){
	elem.parentElement.parentElement.parentElement.classList.toggle('expand-workshop-component');
}
function toggleExpandAll(button){
	var elems = jQuery('.tab-pane.active .workshop_partition_content');
	if(!jQuery(button).hasClass("expanded")){
		jQuery(button).addClass('expanded');
		elems.addClass('expand-workshop-component');
	}else{
		jQuery(button).removeClass('expanded');
		elems.removeClass('expand-workshop-component');
	}
}


function setURLs(key, type){
    let url =  new URL(window.location.href);
    url.searchParams.set(type,key);
    window.location.href= url;
 }
 function removeAllFilters(){
    let url =  new URL(window.location.href);
    let keyword = url.searchParams.get('k');
    var url2 = new URL(window.location.href.split('?')[0]);
	if(keyword){
		url2.searchParams.set('k', url.searchParams.get('k') );
	}
    window.location.href = url2;
 }
 function removeFilter(type){
    let url =  new URL(window.location.href);
    url.searchParams.delete(type);
    window.location.href = url;
 }

function copyTextToClipboard(text) {
	var textArea = document.createElement("textarea");
  
	//
	// *** This styling is an extra step which is likely not required. ***
	//
	// Why is it here? To ensure:
	// 1. the element is able to have focus and selection.
	// 2. if element was to flash render it has minimal visual impact.
	// 3. less flakyness with selection and copying which **might** occur if
	//    the textarea element is not visible.
	//
	// The likelihood is the element won't even render, not even a flash,
	// so some of these are just precautions. However in IE the element
	// is visible whilst the popup box asking the user for permission for
	// the web page to copy to the clipboard.
	//
  
	// Place in top-left corner of screen regardless of scroll position.
	textArea.style.position = 'fixed';
	textArea.style.top = 0;
	textArea.style.left = 0;
  
	// Ensure it has a small width and height. Setting to 1px / 1em
	// doesn't work as this gives a negative w/h on some browsers.
	textArea.style.width = '2em';
	textArea.style.height = '2em';
  
	// We don't need padding, reducing the size if it does flash render.
	textArea.style.padding = 0;
  
	// Clean up any borders.
	textArea.style.border = 'none';
	textArea.style.outline = 'none';
	textArea.style.boxShadow = 'none';
  
	// Avoid flash of white box if rendered for any reason.
	textArea.style.background = 'transparent';
  
  
	textArea.value = text;
  
	document.body.appendChild(textArea);
  
	textArea.select();
  
	try {
	  var successful = document.execCommand('copy');
	  var msg = successful ? 'successful' : 'unsuccessful';
	  // console.log('Copying text command was ' + msg);
	} catch (err) {
	  // console.log('Oops, unable to copy');
	}
  
	document.body.removeChild(textArea);
  }
  
  function copyLink(link) {
	  if(!link){
	copyTextToClipboard(window.location.href);
	  }else{
		var copyText = jQuery(link).parent().parent().parent().parent().children('.card-content').children('.get-post')[0].href;
		copyTextToClipboard(copyText)
	  }
  }

//changing tabs in user profile from navigating from sidebar
	var url = window.location.href;
	var activeTab = url.substring(url.indexOf("#")+1);
	if(activeTab != ""){
	jQuery('a[href="#'+ activeTab +'"]').tab('show')
	}

(function ($) {
	// begin doc.ready (all your custom js code goes inside this function)
	$(document).ready(function () {
		// newsletter add a recipient to sendgrid
		$('form#newslettersendgrid')
			.bootstrapValidator({
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh',
				},
				fields: {
					email: {
						validators: { notEmpty: {} },
					},
				},
			})
			.on('success.form.bv', function (e) {
				// Prevent form submission
				e.preventDefault();
				e.stopImmediatePropagation();
				var email = jQuery(
					'form#newslettersendgrid input[type=email]'
				).val();
				var data = {
					type: 'GET',
					action: 'newsletter_subscription',
					email: email,
				};
				$.post(ajax_handler, data, function (response) {
					//console.log('subscribed');
					// Toast message done @amdswaby
				});
			});
		/// end of newsletter

		/// change password form
		$('form#changePassForm')
			.bootstrapValidator({
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh',
				},
				fields: {
					password: {
						validators: { notEmpty: {} },
					},
				},
			})
			.on('success.form.bv', function (e) {
				// Prevent form submission
				e.preventDefault();
				e.stopImmediatePropagation();
				var password = jQuery(
					'form#changePassForm input[name=typePass]'
				).val();
				var data = {
					type: 'GET',
					action: 'change_password',
					password: password,
				};
				$.post(ajax_handler, data, function (response) {
					$('#changePass').modal('toggle');
				});
			});
		/// end of change password form

		$(document).on('click', 'a[href="#"]', function (e) {
			e.preventDefault();
		});
		// to prevent dropdown menu closing when click
		$(document).on('click', '.dropdown-menu', function (e) {
			e.stopPropagation();
		});
		// checkboxes check logic
		$(document).on('click', 'header .custom-control-input', function () {
			// var tag = $(
			// 	'<span class="btn tag-group" data-value="' +
			// 		value +
			// 		'" data-parent-id="' +
			// 		parentID +
			// 		'" data-id="' +
			// 		termID +
			// 		'"><span class="input">' +
			// 		value +
			// 		'</span><span class="fa fa-times"></span></span>'
			// );
			if ($(this).prop('checked') == true) {
				if ($(this).attr('id') == 'all') {
					$('header .custom-control-input')
						.not($(this))
						.prop('checked', false);
				} else {
					$('header .custom-control-input#all').prop(
						'checked',
						false
					);
				}
			}
		});
		// this to show save button when click on setting tab
		if ($('.update-group').length == 1) {
			$(document).on('shown.bs.tab', 'a[href="#settings"]', function (e) {
				$('.update-group').removeClass('d-none');
			});
			$(document).on(
				'shown.bs.tab',
				'a[href="#groups"], a[href="#posts"]',
				function (e) {
					$('.update-group').addClass('d-none');
				}
			);
		}
		if ($('a[href="#groups"]').length == 1) {
			$(document).on('shown.bs.tab', 'a[href="#groups"]', function (e) {
				if (
					$(this)
						.parents('.content-section_header.tabs')
						.find('a[data-target="#newGroup"]').length == 1
				) {
					$(this)
						.parents('.content-section_header.tabs')
						.find('a[data-target="#newGroup"]')
						.removeClass('d-none');
				}
			});
			$(document).on(
				'shown.bs.tab',
				'a[href="#bookmarked"], a[href="#posts"] , a[href="#settings"]',
				function (e) {
					if (
						$(this)
							.parents('.content-section_header.tabs')
							.find('a[data-target="#newGroup"]').length == 1
					) {
						$(this)
							.parents('.content-section_header.tabs')
							.find('a[data-target="#newGroup"]')
							.addClass('d-none');
					}
				}
			);
		}

		$(document).on('shown.bs.tab', 'a[href="#settings"]', function (e) {
			select2dropDown();
			if ($('.view-content_container').length >= 1) {
				autoExpand(
					document.querySelector('.form-group_setting textarea')
				);
			}
		});

		$(document).on('shown.bs.tab', 'a[href="#settings"]', function (e) {
			select2dropDown();
			if ($('.view-content_container').length >= 1) {
				autoExpand(
					document.querySelector('.form-group_setting textarea')
				);
			}
		});

		// remove .folder-opened when clicking on back btn
		$(document).on('click', '.view-tab#backToView', function () {
			$('.section-wrapper').removeClass('folder-opened');
		});
		// reset select 2 after closing model
		$('#deletePost').on('hidden.bs.modal', function (e) {
			$('#formDelete')[0].reset();
			jQuery('select').val('').trigger('change');
		});
		// remove member group setting
		$(document).on('click', '.delete-member', function (e) {
			var ele = $(this),
				dataId = ele.data('id'),
				unselectedOPtion = $(
					'.form-group_settings.form-group-member option[value="' +
						dataId +
						'"]'
				);

			unselectedOPtion.prop('selected', false);
			$(
				'.form-group_settings.form-group-member select[name="members"]'
			).trigger('change.select2');

			ele.parents('.group-member').fadeOut(300, function () {
				ele.remove();
			});
		});

		$(document).on('click', 'input.copy-clipboard', function (e) {
			copyClipBoard('input.copy-clipboard');
			$(this).tooltip('show');
			setTimeout(function () {
				$('input.copy-clipboard').tooltip('hide');
			}, 1000);
		});

		$(document).on(
			'click',
			'.new-group .new-content_info .uppy-FileInput-input',
			function (e) {
				var inst = window.groupPhoto;
				inst.reset();
			}
		);
		$(document).on('click', '.preview-card .change-photo input', function (
			e
		) {
			if (
				jQuery('.preview-card .avatar:not(.group-photo) .change-photo')
					.length > 0
			) {
				var instUserPhoto = window.userPhoto;
				instUserPhoto.reset();
			}
			if (
				jQuery('.preview-card .avatar.group-photo .change-photo')
					.length > 0
			) {
				var groupPhotoPreview = window.groupPhotoPreview;
				groupPhotoPreview.reset();
			}
		});
		$(document).on('click', '.viewPass', function (e) {
			e.preventDefault();
			$(this).toggleClass('hidePass');
			var ele = $(this),
				input = ele.siblings('input');

			if (input.attr('type') == 'password') {
				input.attr('type', 'text');
			} else if (input.attr('type') == 'text') {
				input.attr('type', 'password');
			}
		});

		// add listener on card-folder-link
		addListener('.card-folder-link', 'click', openGroupFolder);

		$.fn.select2.defaults.defaults['language'].inputTooShort = function () {
			return 'من فضلك ادخل الحرف الاول';
		};
		$.fn.select2.defaults.defaults['language'].searching = function () {
			return 'جاري البحث....';
		};
		$(document).on(
			'input',
			'input[type="search"][data-callback]',
			function (e) {
				var valLength = $(this).val().length;
				var callBack = $(this).data('callback');
				if (valLength >= 3) {
					var x = eval(callBack);
					if (typeof x == 'function') {
						x(e);
					}
				}
			}
		);
		$(document).on('input', '.form-group_comment .form-control', function (
			e
		) {
			var valLength = $(this).val().length;
			if (valLength >= 1) {
				$(this).css('height', '120px');
			} else {
				$(this).removeAttr('style');
			}
		});

		$(document).on(
			'click',
			'main .right-side_info .article-title',
			function (e) {
				e.preventDefault();
				var dataTarget = $(this).data('target'),
					activeEditor = tinymce.activeEditor,
					elementInEditor = activeEditor
						.getBody()
						.querySelector('[data-mo-id="' + dataTarget + '"]'),
					elementInEditorOffset = $(elementInEditor).offset().top;

				$(activeEditor.getBody())
					.parent('html')
					.animate(
						{
							scrollTop: elementInEditorOffset,
						},
						700,
						function () {
							activeEditor.focus();
							activeEditor.selection.select(
								elementInEditor,
								true
							);
						}
					);
				$(activeEditor.getBody()).animate(
					{
						scrollTop: elementInEditorOffset,
					},
					700
				);
			}
		);

		// inject/remove post id into delete post modal
		$(document).on('show.bs.modal', '#deletePost, #reportPost', function (
			e
		) {
			if (hasClasse(e.relatedTarget, 'remove')) {
				document.getElementById('formDelete').dataset.id =
					e.relatedTarget.dataset.id;
			} else if (hasClasse(e.relatedTarget, 'report-btn')) {
				document.getElementById('formReport').dataset.id =
					e.relatedTarget.dataset.id;
			}
		});

		$(document).on('hidden.bs.modal', '#deletePost, #reportPost', function (
			e
		) {
			if (hasClasse(e.relatedTarget, 'remove')) {
				document.getElementById('formDelete').dataset.id = '';
			} else if (hasClasse(e.relatedTarget, '.report-btn')) {
				document.getElementById('formReport').dataset.id = '';
			}
		});

		// create new days
		$(document).on('click', '.btn-days_wrapper a.tab', function () {
			var stamp = 'tab_' + new Date().getTime(),
				daysNumber =
					$('.btn-days_wrapper .list-group a:not(.tab)').length + 1,
				dayBtn = $(
					'<a class="btn" href="#' +
						stamp +
						'" role="tab" aria-controls="' +
						stamp +
						'" data-post> اليوم ' +
						daysNumber +
						'</a>'
				),
				dayTap = $(
					'<div class="tab-pane drag-option" id="' +
						stamp +
						'" aria-labelledby="' +
						stamp +
						'" role="tabpanel"></div>'
				),
				sidebarWrapper = $(
					'<div class="d-block" data-mo-target="' + stamp + '"></div>'
				);

			if (daysNumber > 1) {
				dayBtn.prepend($('<i class="icon-minus"></i>'));
			}

			$('.btn-days_wrapper .list-group').append(dayBtn);
			$('.workshop-content_wrapper .tab-content').append(dayTap);
			$('.right-side_info .workshop-wrapper').append(sidebarWrapper);
			dayBtn.tab('show');
			// pass an array or element to drapdrop
		});
		$(document).on('dblclick', '.btn-days_wrapper a.tab', function (e) {
			e.preventDefault();
		});

		// create first day
		if ($('.btn-days_wrapper a.tab').length > 0) {
			if ($('.btn-days_wrapper .btn:not(.tab)').length < 1) {
				if ($('.activity-content').length == 0) {
					$('.btn-days_wrapper a.tab').click();
				}
			}
		}
		// tab between days
		$(document).on('click', '.btn-days_wrapper .btn:not(.tab)', function (
			e
		) {
			e.preventDefault();
			e.stopPropagation();
			$(this).tab('show');
		});

		// add workshop component to active day

		
		$(document).on(
			'click',
			'.dropdown-workshop_partition .dropdown-item',
			function (e) {
				e.preventDefault();
				var el = $(this),
					stamp = 'panel_' + new Date().getTime(),
					elColor = el.attr('class').replace('dropdown-item', ''),
					elText = el.text(),
					mainComponent = $(
						'<div class="workshop_partition_content ' +
							elColor +
							'" id="' +
							stamp +
							'" data-post><div class="header handle"><div><a href="#"><i class="icon-drag"></i></a><span>' +
							elText +
							//renaming workshop boxes
							// "<input class='workshop_partition_content--title' type='text' placeholder="+ elText+" value="+elText+">"+

							'</span></div><div><button onclick="toggleExpand(this)" class="expand-collapse-component"><i class="icon-notes"></i>expand/collapse item</button><a href="#notesSidebar"><i class="icon-notes"></i></a><a href="#commentsSidebar"><i class="icon-comment"></i></a><a href="#materialSidebar"><i class="icon-material"></i></a><a href="#attachesSidebar"><i class="icon-sources-alt"></i></a><a href="#" title="delete entry" class="delete-entry"><i class="icon-delete"></i></a></div></div><div class="workshop-content"><div class="p-0"><div class="hyperlink"><div><input type="text" name="hyperlink"><button class="attach"><i class="icon-attach-alt"></i></button></div></div><form data-bv-live="disabled"></form><div class="row no-gutters default"><div class="col-md-1"><input class="form-control workshop-input workshop-input_number" placeholder="0"></div><div class="col-md-3"><textarea class="form-control workshop-input workshop-input_title" placeholder="عنوان"></textarea></div><div class="col-md-6"><textarea class="form-control workshop-input workshop-input_content" placeholder="تفاصيل"></textarea></div> <div class="col-md-2"><div class="form-group"><textarea class="form-control workshop-input workshop-input_notes" name="" placeholder="ملاحظات"></textarea></div></div></div></div></div></div></div>'
					),
					// data-bv-live="disabled"
					sidebarWorkshop = $(
						'<a href="#" class="workshop_partition ' +
							elColor +
							'"data-panel="' +
							stamp +
							'"><span class="get-time">0</span><span class="get-text">' +
							elText +
							'</span><i class="icon-tringle-down"></i></a>'
					),
					activeTab = $(
						'main .workshop-content_wrapper .tab-content .tab-pane.active'
					).attr('id');

				// append sidebar workshop
				$(
					'main .right-side_info .workshop-wrapper div[data-mo-target="' +
						activeTab +
						'"]'
				).append(sidebarWorkshop);
				// create active tab-pane if there's no one
				if (
					$(
						'main .workshop-content_wrapper .tab-content .tab-pane.active'
					).length <= 0
				) {
					$('.btn-days_wrapper .btn.tab').click();
				}

				// then hide dropdown
				$('.add-workshop_partition').dropdown('hide');

				// append main component to active day
				$(
					'main .workshop-content_wrapper .tab-content .tab-pane.active'
				).append(mainComponent);
				bsValidatorInit();
				validateNumbers('.workshop-input_number');
			}
		);
		$(document).on(
			'shown.bs.tab',
			'.btn-days_wrapper a[data-post]',
			function (e) {
				var eleId = $(e.target).attr('aria-controls');

				$(
					'main .right-side_info .workshop-wrapper div[data-mo-target="' +
						eleId +
						'"]'
				)
					.addClass('d-block')
					.removeClass('d-none')
					.siblings('div[data-mo-target]')
					.addClass('d-none')
					.removeClass('d-block');
			}
		);
		var i=1;
		$(document).on(
			'focus',
			'.workshop-content .default .workshop-input',
			function () {
				var workshopContainerId = $('.workshop_partition_content').attr(
						'id'
					),
					rowsLength = $('.workshop-content .row:not(.default)')
						.length,
					addRow = $(
						'<div class="row no-gutters"><div class="col-md-1 d-flex justify-content-center align-items-center flex-column"><a class="incMin" href="#"><i class="icon-plus"></i></a><div class="form-group"><input type="text" value="0" class="form-control workshop-input workshop-input_number" name="time_' +
							rowsLength +
							'_' +
							workshopContainerId +
							'" maxlength="3" placeholder="0" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></div><a class="decMin" href="#"><i class="icon-minus"></i></a></div><div class="col-md-3"><div class="form-group"><textarea class="form-control workshop-input workshop-input_title" name="title_' +
							rowsLength +
							'_' +
							workshopContainerId +
							'" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></textarea></div></div><div class="col-md-6"><div class="form-group"><textarea class="form-control workshop-input workshop-input_content" name="content_' +
							rowsLength +
							'_' +
							workshopContainerId +
							'" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" id="workshop-textarea_'+i+'"></textarea></div></div><div class="col-md-2"><div class="form-group"><textarea class="form-control workshop-input workshop-input_notes" name="notes_' +
							rowsLength +
							'_' +
							workshopContainerId +
							'"></textarea></div></div>'
					),
					workshopContainer = $(this)
						.parents('.workshop-content')
						.find('form');
						i++;

				// add delete button if row not the only one
				if (
					$(this)
						.parents('.workshop-content')
						.find('.row:not(.default)').length > 0
				) {
					addRow
						.children('.col-md-1')
						.prepend(
							$(
								'<a href="#" title="delete row" class="delete-row"><i class="icon-delete"></i></a>'
							)
						);
				}

				// check if it's first row
				if ($('.workshop-content .row:not(.default)').length == 0) {
					workshopContainer.prepend(addRow);
				} else {
					workshopContainer.append(addRow);
				}

				// prevent user from typing on input we focus on
				$(this).attr('readonly', 'readonly');

				// focus on new input title
				// commented coz doesn't work right with drag
				addRow.find('.workshop-input_title').focus();

				// validate only numbers on number textarea
				validateNumbers('.workshop-input_number');

				// get name attr to validate on it
				var filedTimeName =
						'time_' + rowsLength + '_' + workshopContainerId,
					filedTitleName =
						'title_' + rowsLength + '_' + workshopContainerId,
					filedContentName =
						'content_' + rowsLength + '_' + workshopContainerId,
					newElemTime = $('input[name="' + filedTimeName + '"]'),
					newElemTitle = $('textarea[name="' + filedTitleName + '"]'),
					newElemContent = $(
						'textarea[name="' + filedContentName + '"]'
					);

				// add new fields to bvs
				$('.workshop-content form').bootstrapValidator(
					'addField',
					newElemTime
				);
				$('.workshop-content form').bootstrapValidator(
					'addField',
					newElemTitle
				);
				$('.workshop-content form').bootstrapValidator(
					'addField',
					newElemContent
				);
			}
		);

		$(document).on('click', '.workshop-content .row a', function () {
			var elemClaa = $(this).attr('class'),
				numberInputOld = $(this)
					.siblings('.form-group')
					.children('input.workshop-input_number')
					.val();
			// increase min
			if (elemClaa == 'incMin') {
				// set val to number if it's not
				if (Number.isNaN(parseFloat(numberInputOld))) {
					numberInputOld = 0;
				}
				// not more than 3 digits
				if (numberInputOld < 99) {
					$(this)
						.siblings('.form-group')
						.children('input.workshop-input_number')
						.val(parseFloat(numberInputOld) + 1);
				}
				// decrease min
			} else if (elemClaa == 'decMin') {
				// not less than 0
				if (parseFloat(numberInputOld) > 0) {
					$(this)
						.siblings('.form-group')
						.children('input.workshop-input_number')
						.val(parseFloat(numberInputOld) - 1);
				}
			} else {
				return false;
			}

			$(this)
				.siblings('.form-group')
				.children('input.workshop-input_number')
				.parents('form')
				.bootstrapValidator(
					'revalidateField',
					$(this)
						.siblings('.form-group')
						.children('input.workshop-input_number')
						.attr('name')
				);

			// trigger change to add time to sidebar
			$(this)
				.siblings('.form-group')
				.children('input.workshop-input_number')
				.trigger('change');
		});

		$(document).on(
			'input',
			'.workshop-content .row:not(.default) .form-control.workshop-input',
			function (e) {
				var ele = $(this),
					eleParent = ele.parent('.form-group'),
					eleParentCol = eleParent.parent();
				if (eleParent.hasClass('has-error')) {
					eleParentCol.addClass('border border-warning');
				} else {
					eleParentCol.removeClass('border border-warning');
				}
			}
		);

		$(document).on('click', '.edit-setting', function (e) {
			e.preventDefault();
			var ele = $(this),
				input = document.querySelectorAll(
					'.form-group_setting .form-control'
				);

			ele.find('div:last-of-type').toggleClass('d-none');
			ele.find('div:first-of-type').toggleClass('d-none');
			ele.siblings('a').toggleClass('d-none');

			$.each(input, function (index, val) {
				if (val.getAttribute('disabled') == 'disabled') {
					val.removeAttribute('disabled');
				} else {
					val.setAttribute('disabled', 'disabled');
				}
			});
			$('.avatar.changeable .change-photo').toggleClass('editable');
			var dataAvatar = $('.avatar.changeable').attr('data-avatar');
			var cssAvatar = $('.avatar.changeable').css('background-image').replace(/^url\(['"](.+)['"]\)/, '$1');
			if(dataAvatar != cssAvatar){
				$('.avatar.changeable').css('background-image','url('+dataAvatar+')');
			}
		});
		$(document).on('click','#list-settings',function() {
			$('.avatar.changeable .change-photo').toggleClass('editable');
			var dataAvatar = $('.avatar.changeable').attr('data-avatar');
			var cssAvatar = $('.avatar.changeable').css('background-image').replace(/^url\(['"](.+)['"]\)/, '$1');
			if(dataAvatar != cssAvatar){
				$('.avatar.changeable').css('background-image','url('+dataAvatar+')');
			}
		});
		// validate update group settings form
		$(document).on('click', '.update-group', function (e) {
			$('#formUpdateGroup').data('bootstrapValidator').validate();
		});

		// fire activity function after reload if no panel created

		if (
			$('.activity-content').length == 1 &&
			$('.workshop_partition_content').length == 0
		) {
			activityCreation();
		}
		// to set the height of .workshop-input_content after loading
		(function () {
			var textContentWorkShop = document.querySelectorAll(
				'.workshop-input_content'
			);
			$.each(textContentWorkShop, function (index, val) {
				autoExpand(val);
			});
		})();
		$(document).on(
			'shown.bs.tab',
			'.btn-days_wrapper a.btn:not(.tab)',
			function (e) {
				var elehref = $(this).attr('href'),
					inputsInside = document.querySelectorAll(
						'.tab-pane' + elehref + ' .workshop-input_content'
					);

				$.each(inputsInside, function (index, val) {
					autoExpand(val);
				});
			}
		);

		$(document).on('click', '#pc .uppy-FileInput-btn', function () {
			var instAttachPc = window.attachPc;

			$('.wrapper-file-added').remove();
			if (instAttachPc) {
				instAttachPc.reset();
			}
			
		});
		$(document).on('click', '.wrapper-file-added .btn-close', function () {
			var ele = $(this);

			ele.parents('.wrapper-file-added').remove();
			instAttachPc = window.attachPc;
			instAttachPc.reset();
		});

		$(document).on('click', '.header div:last-of-type a', function (e) {
			e.preventDefault();
			$('.mo-icon-sidebar[href="' + $(this).attr('href') + '"]').click();
		});

		$(document).on('click', 'a.save-settings', function (e) {
			e.preventDefault();
			e.stopImmediatePropagation();
			var name = $('#fullname').val();
			$('.info.info-sm a').text(name);

			var desc = $('.textarea_desc textarea').val();
			$('.card-text').text(desc);

			var dataAvatar = $('.avatar.changeable').attr('data-avatar');
			var cssAvatar = $('.avatar.changeable').css('background-image').replace(/^url\(['"](.+)['"]\)/, '$1');
			if(dataAvatar != cssAvatar){
				$('.avatar.changeable').attr('data-avatar',cssAvatar);
			}

			$('#formUpdateUser').submit();
		});

		$(document).on('change','.workshop-input.workshop-input_number',function (e) {
			var allInput = $(this).parents('.workshop_partition_content').find('.workshop-input.workshop-input_number[name]'),
			sidebarPanel = $('.workshop_partition[data-panel="' + $(this).parents('.workshop_partition_content').attr('id') +'"]').find('.get-time'),
			inputVal = parseInt(0);
			allInput.each(function (index, val) {
				if (!$(this).val()) {
					$(this).val(0);
				}
				inputVal = inputVal + parseInt(englishArabicNumber($(val).val()));
			});
			sidebarPanel.text(inputVal);
		});

		$(document).on('click', '#formRegister .btn', function () {
			if (!jQuery('#formRegister').data('bootstrapValidator').isValid()) {
				toastInit('error_toast', ' كل * يجب ملئها بالبيانات الصحيحه');
			}
		});

		// trigger change after load to put number in right sidebar
		if (jQuery('.workshop-input_number').length > 0) {
			jQuery('.workshop-input_number').trigger('change');
		}

		$(document).on('click', 'a.delete-row', function (e) {
			e.preventDefault();
			$(this).parents('.row').remove();
		});

		$(document).on('click', 'a.delete-entry', function (e) {
			e.preventDefault();
			var panel_id = $(this)
					.parents('.workshop_partition_content')
					.attr('id'),
				sidebar_link = $(
					'.right-side_info a.workshop_partition[data-panel="' +
						panel_id +
						'"]'
				);

			$(this).parents('.workshop_partition_content').remove();
			sidebar_link.remove();
		});

		$(document).on(
			'click',
			'.btn-days_wrapper a.btn i.icon-minus',
			function (e) {
				e.preventDefault();
				e.stopImmediatePropagation();

				var target_id = $(this).parents('a.btn').attr('aria-controls'),
					target_tab = $('#' + target_id),
					target_side = $(
						'.workshop-sidebar div[data-mo-target="' +
							target_id +
							'"]'
					),
					days_list = $(this).parents('#list-tab'),
					days;

				target_id = $(this).parents('a.btn').remove();
				target_tab.remove();
				target_side.remove();

				days = days_list.children('a:not(.tab)');

				days.last().click();

				$.each(days, function (index, val) {
					$(val)
						.text('اليوم ' + (index + 1))
						.prepend($('<i class="icon-minus"></i>'));
				});
			}
		);

		$(document).on('click', '.btn-upload-attach', function (e) {
			uploadAttach(e);
		});

		// init helpers functions
		select2dropDown();
		bsValidatorInit();
		avatarInit();
		getValidateEmailUrl();
		uppyUpLoader();
		tinyInit();
		goingToHeaders();
		validateNumbers('.workshop-input_number');
		dragDrop();


		var textareaID="workshop-textarea_0";
		var selectStart = 0;
		var selectEnd = 0;
		$(document).on("click",".workshop-input", function () {
		   textareaID = $(this).attr('id');
		    selectStart = this.selectionStart;
            selectEnd = this.selectionEnd;
            
		});
      
        $('[href="#attachesSidebar"]').on('click',function(){
            if (selectStart && selectEnd) {
            	$('.hyperlink').fadeIn();
            }
        });
        $(document).on('click', '.attach',function(e){
        	var link = $('.hyperlink input').val();
        	window.attachLink = link;
            var linkTag = '<a href="'+link+'" target="_blank">';
            $('.hyperlink').fadeOut();         
            var x= $('#'+textareaID).val();
            var text = x.slice(selectStart,selectEnd);
            $('#'+textareaID).val(x.slice(0,selectEnd)+'</a>'+x.slice(selectEnd));
            x = $('#'+textareaID).val();
            $('#'+textareaID).val(x.slice(0,selectStart)+linkTag+x.slice(selectStart));
            $('.hyperlink input').val('');
           	//addAttachLink(link,text);
        });
      
        $("body").bind("DOMNodeInserted", function() {
		   $(this).find('#search_side_result a').attr('target','_blank');
		   $(this).find('#search_side_result a').removeClass('get-post');
		});

        $('[data-edit-post]').on('click', function(){
        	var edit = $(this).data('edit-post');
        	$('[data-post-info='+edit+']').fadeIn();

        });
        if($('.duration-counter span').length != 0){
        	var Initialduration = parseInt($('.duration-counter span').text());
        	var duration = 0;
        	$('.workshop_partition').each(function(){
        		var number = $(this).find('.get-time').text();
        		duration += parseInt(englishArabicNumber(number));
        	});
        	console.log(duration);
        	var newDuration = Initialduration - duration;
        	if(newDuration < 3){
        		$('.duration-counter span').css('color','red');	
        	}
        	$('.duration-counter span').text(newDuration);	
        }else{
        	var Initialduration = parseInt($('.duration-content p').text());	
        }
        $(document).on('change','.workshop-input_number', function(){
        	var duration = 0;
        	$('.workshop_partition').each(function(){
        		var number = $(this).find('.get-time').text();
        		duration += parseInt(englishArabicNumber(number));
        	});
        	console.log(duration);
        	var newDuration = Initialduration - duration;
        	if(newDuration <= 3){
        		$('.duration-counter span').css('color','red');	
        	}else{
        		$('.duration-counter span').css('color','black');	
        	}
        	if(newDuration >= 0){
        		$('.duration-counter span').text(newDuration);
        	}else{
        		toastInit('error_toast', 'لقد تجاوزت الوقت');
        	}
        });

        $('#materialQty').keypress(function (e){
			var keyPressed = e.which;
			if( ((keyPressed >= 48) && (keyPressed <= 57)) || ((keyPressed >= 1632) && (keyPressed <= 1641))) {
				var eleParent = $(this).parent('.form-group');
				eleParent.removeClass('has-error');
				eleParent.addClass('has-success');
				$(this).attr('data-bv-digits-message','');
			}else{
				$(this).attr('data-bv-digits-message','هذا الحقل يحتوي على ارقام فقط');
				e.preventDefault();
			}
		});
        

	}); // end doc.ready
})(jQuery);
function workshopTime(inputEle) {
	var workshopId = jQuery(inputEle)
			.parents('.workshop_partition_content')
			.attr('id'),
		allInput = jQuery('#' + workshopId).find(
			'.workshop-input.workshop-input_number[name=]'
		),
		sidebarPanel = jQuery(
			'.workshop_partition[data-panel="' + workshopId + '"]'
		);

	allInput.each(function (index, val) {
		var NumVal = parseInt(jQuery(val).val());

		//console.log(val);
		//console.log(index);
	});
}
function validateNumbers(selector) {
	jQuery(selector).keypress(function (e) {
		var keyPressed = event.which;
		if (keyPressed <= 57) {
			// return true;
			if (keyPressed == 39 || keyPressed == 45) {
				e.preventDefault();
			}
		}else if(keyPressed >= 1632 && keyPressed <= 1641){

		}
		 else {
			e.preventDefault();
		}
	});
}

function autoExpand(field) {
	// Reset field height
	field.style.height = 'inherit';

	// Get the computed styles for the element
	var computed = window.getComputedStyle(field);

	// Calculate the height
	var height =
		parseInt(computed.getPropertyValue('border-top-width'), 10) +
		parseInt(computed.getPropertyValue('padding-top'), 10) +
		field.scrollHeight +
		parseInt(computed.getPropertyValue('padding-bottom'), 10) +
		parseInt(computed.getPropertyValue('border-bottom-width'), 10);

	field.style.height = height + 'px';
}

function englishArabicNumber(number){
	var numberArray = number.split('');
	var engList = ["0","1","2","3","4","5","6","7","8","9"];
	var arList = ["٠","١","٢","٣","٤","٥","٦","٧","٨","٩"];
	var engNumber='';
	for (var i = 0; i < numberArray.length; i++) {
		var engIndex = jQuery.inArray(numberArray[i], engList);
		if(engIndex == -1){
			var arIndex = jQuery.inArray(numberArray[i], arList);
			engNumber+=engList[arIndex];

		}else{
			return number;
		}
	}
	return engNumber;
	/*var engIndex = jQuery.inArray(number, engList);
	if(engIndex == -1){
		var arIndex = jQuery.inArray(number, arList);
		return engList[arIndex];

	}else{
		return number;
	}*/


}
document.addEventListener(
	'input',
	function (event) {
		if (jQuery(event.target).hasClass('workshop-input')) {
			autoExpand(event.target);
		}
	},
	false
);
// createWordListAnimation(document.querySelector('.animation'), 1000 /* (ms) */);
function copyClipBoard(elem) {
	var copyText = document.querySelector(elem);
	copyText.select();
	copyText.setSelectionRange(0, 9999999);
	document.execCommand('copy');
}

// push id into url view post p.g
// function processAjaxData(urlPath) {
// 	window.history.pushState({ pageTitle: urlPath }, '', urlPath);
// }
function goingToHeaders() {
	jQuery(document).on('click', '.card-titles .article-title', function (e) {
		e.preventDefault();
		var eleHref = jQuery(this).data('target'),
			pageUrl = window.location.pathname + '#' + eleHref;
		window.history.pushState({ pageTitle: pageUrl }, '', pageUrl);

		jQuery('html,body').animate({
			scrollTop:
				jQuery('.heading[data-mo-id="' + eleHref + '"]').offset().top -
				100,
		});
		jQuery(this).siblings().removeClass('active');
		jQuery(this).addClass('active');
	});
}
function tinyInit() {
	jQuery('textarea#tiny').tinymce({
		height: '100%',
		menubar: false,
		language: 'ar',
		resize: true,
		content_css: [
			wpApiSettings.siteurl +
				'/wp-content/themes/mowazi/assets/css/tiny-fonts.css',
			'https://fonts.googleapis.com/css?family=Cairo:400,700|Tajawal&display=swap&subset=arabic',
		],
		content_css_cors: true,
		plugins: [
			'table quickbars print link lists advlist directionality image fullpage paste ',
		],
		statusbar: false,
		directionality: 'rtl',
		quickbars_insert_toolbar: 'quickimage quicktable',
		font_formats:
			'Tajawal=' +
			'Tajawal' +
			',' +
			'sans-serif;DiodrumLight =' +
			'DiodrumArabic-Light' +
			',' +
			'sans-serif;DiodrumMedium =DiodrumArabic-Medium' +
			',' +
			'sans-serif;DiodrumBold =DiodrumArabic-Bold' +
			',' +
			'sans-serif;Cairo ="Cairo"' +
			',' +
			'sans-serif;Noto Kufi = NotoKufiArabic sans-serif;Noto Kufi Bold = NotoKufiArabic-Bold sans-serif;',
		fontsize_formats: '11px 12px 14px 16px 18px 24px 36px 48px',
		fullpage_default_font_family: "'Tajawal', sans-serif",
		toolbar:
			'undo redo print  backcolor | formatselect | ' +
			'fontsizeselect | fontselect |  Bold italic Underline  forecolor | link image table| alignright aligncenter alignleft numlist bullist indent outdent RemoveFormat ltr',
		advlist_bullet_styles: 'square',
		advlist_number_styles: 'lower-alpha',
		toolbar_sticky: true,
		setup: function (editor) {
			editor.on('init', function () {
				editor.focus();
			});
		},
		init_instance_callback: NodeChange,
		formats: {
			// Changes the default format for h1 to have a class of heading
			h1: { block: 'h1', classes: 'heading' },
			h2: { block: 'h2', classes: 'heading' },
			h3: { block: 'h3', classes: 'heading' },
			h4: { block: 'h4', classes: 'heading' },
			h5: { block: 'h5', classes: 'heading' },
			h6: { block: 'h6', classes: 'heading' },
		},
	});
}
function NodeChange(editor) {
	editor.on('NodeChange', function (e) {
		// var selectedElements = new DOMParser().parseFromString(editor.selection.getContent({format : 'html'}), "text/html").querySelectorAll('.heading');

		// jQuery(selectedElements).each(function(index , val) {
		// 	console.log(val.textContent);

		// })

		var valid = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
			el = editor.selection.getNode();

		// check if  element  H tag

		if (!valid.includes(el.nodeName.toLowerCase())) {
			if (!get_closest_parent(el, '.heading')) {
				return false;
			}
		}

		var elText = valid.includes(el.nodeName.toLowerCase())
				? el.textContent
				: get_closest_parent(el, '.heading').textContent,
			elDataAttr =
				typeof el.dataset.moId != 'undefined'
					? el.dataset.moId
					: get_closest_parent(el, '.heading').dataset.moId;

		setSidebarTagText(
			elText,
			elDataAttr,
			e.target.getDoc().querySelector('body')
		);
	});
	editor.on('ExecCommand', function (e) {
		if (e.command !== 'mceToggleFormat') {
			return false;
		}

		var valid = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
			stamp = new Date().getTime(),
			el = tinymce.activeEditor.selection.getNode(),
			editorBody = e.target.getDoc().querySelector('body');

		// return if the format selection not in the valid array
		if (!valid.includes(e.value)) {
			return false;
		}

		// return if the title already has our data attr, this means it has been created and appended to the sidebar before
		if (el.dataset.moId) {
			return false;
		}

		// if the created element is a direct title
		if (valid.includes(el.nodeName.toLowerCase())) {
			// set the id
			el.dataset.moId = 'header-title_' + stamp;
		} else {
			// its a child node of the title that got created by tinymce ex: span
			var el = get_closest_parent(el, '.heading');

			if (!el) {
				return false;
			}
			// return if the title already has our data attr, this means it has been created and appended to the sidebar before
			if (el.dataset.moId) {
				return false;
			}

			el.dataset.moId = 'header-title_' + stamp;
		}
		createSidebarTag(el.dataset.moId, editorBody);
	});
	editor.on('BeforeExecCommand', function (e) {
		if (e.command == 'mceToggleFormat') {
			var valid = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
				el = tinymce.activeEditor.selection.getNode();
			if (e.value == 'p' || e.value == 'pre') {
				if (valid.includes(el.nodeName.toLowerCase())) {
					jQuery(
						'main .container-post__right_side .right-side_info .article-title[data-target="' +
							el.dataset.moId +
							'"]'
					).remove();
					tinymce.activeEditor.dom.removeAllAttribs(el);
				}
			} else {
				if (valid.includes(el.nodeName.toLowerCase())) {
					jQuery(
						'main .container-post__right_side .right-side_info .article-title[data-target="' +
							el.dataset.moId +
							'"]'
					).remove();
				}
			}
		}
	});
	editor.on('NewBlock', function (e) {
		if (e.newBlock.dataset.moId) {
			var stamp = new Date().getTime(),
				editorBody = e.target.getDoc().querySelector('body');

			e.newBlock.dataset.moId = 'header-title_' + stamp;
			setSidebarTagText(
				e.newBlock.textContent,
				e.newBlock.dataset.moId,
				editorBody
			);
		}
	});
	editor.on('keyup', function (e) {
		var selectedElements = new DOMParser()
			.parseFromString(
				editor.selection.getContent({ format: 'html' }),
				'text/html'
			)
			.querySelectorAll('.heading');

		jQuery(selectedElements).each(function (index, val) {
			//console.log(e.keyCode);
		});

		if (e.keyCode === 8) {
			if (
				tinymce.activeEditor.getDoc().querySelector('body')
					.textContent == ''
			) {
				jQuery(
					'main .container-post__right_side .right-side_info .article-title'
				).remove();
			}

			jQuery(
				'main .container-post__right_side .right-side_info .article-title'
			).each(function (ind, val) {
				var targetId = jQuery(val).data('target');

				if (
					tinymce.activeEditor
						.getDoc()
						.querySelector('body')
						.querySelector(
							'.heading[data-mo-id="' + targetId + '"]'
						) == null
				) {
					jQuery(val).remove();
				}
			});
		}
	});
}

function createSidebarTag(dataId, editorBody) {
	var titleIndex = jQuery(editorBody)
			.find('.heading')
			.index(
				jQuery(editorBody).find('.heading[data-mo-id="' + dataId + '"]')
			),
		sidebar = jQuery('main .container-post__right_side .right-side_info'),
		sidebarTitle = jQuery(
			'<a href="#" data-target="' +
				dataId +
				'" class="article-title"></a>'
		);

	if (titleIndex == 0) {
		sidebar.prepend(sidebarTitle);
	} else {
		jQuery(sidebar.find('.article-title')[titleIndex - 1]).after(
			sidebarTitle
		);
		//console.log(jQuery(sidebar.find('.article-title')[titleIndex - 1]));
	}
}
function setSidebarTagText(elText, moId, editorBody) {
	var sidebarTitles = jQuery(
		'main .container-post__right_side .right-side_info .article-title[data-target="' +
			moId +
			'"]'
	);

	if (elText == '') {
		sidebarTitles.remove();
	} else {
		if (sidebarTitles.length > 0) {
			sidebarTitles.text(elText);
		} else {
			createSidebarTag(moId, editorBody);
		}
	}
}
function checkIfHeadersExists(editor) {
	var aTag = jQuery('main .container-post__right_side .right-side_info a'),
		headerTag = editor
			.getDoc()
			.querySelector('body')
			.querySelectorAll('.heading');

	jQuery.each(aTag, function (index, val) {
		var aTagHref = jQuery(val).attr('href');

		if (!editor.getDoc().querySelector('body').querySelector(aTagHref)) {
			jQuery(val).remove();
		}
	});
}

function hasClasse(el, className) {
	return el.classList
		? el.classList.contains(className)
		: new RegExp('\\b' + className + '\\b').test(el.className);
}

function addClasse(el, className) {
	if (el.classList) el.classList.add(className);
	else if (!hasClasse(el, className)) el.className += ' ' + className;
}

function removeClasse(el, className) {
	if (el.classList) {
		el.classList.remove(className);
	} else {
		el.className = el.className.replace(
			new RegExp('\\b' + className + '\\b', 'g'),
			''
		);
	}
}

function addListener(selector, event, callback) {
	var selectors = document.querySelectorAll(selector);
	for (var i = selectors.length - 1; i >= 0; i--) {
		selectors[i].addEventListener(event, callback);
	}
}

// bd validation
function bsValidatorInit() {
	var forms = jQuery('form');
	jQuery.each(forms, function (index, val) {
		jQuery(val).bootstrapValidator();
	});
}
// init avatar
function avatarInit() {
	if (jQuery('[data-avatar]').data('avatar') !== null || jQuery('[data-avatar]').data('avatar') !== '') {
		jQuery('[data-avatar]').css('background-image', function () {
			var bg = 'url(' + jQuery(this).data('avatar') + ')';
			return bg;
		});
	}
}

function select2dropDown() {
	var eleSelect = document.querySelectorAll('select');

	jQuery.each(eleSelect, function (index, val) {
		// var searchPlaceholder = jQuery(eleSelect).attr('data-searchBox');
		var dropDownParentGroup = jQuery(this).closest('.form-group');
		var select2options = {
			// search filter
			minimumResultsForSearch: Infinity,
			dir: 'rtl',
			dropdownParent: dropDownParentGroup,

			// hashtag tag

			tags: false,
			tokenSeparators: [','],
			createTag: function (params) {
				var term = jQuery.trim(params.term);

				if (term === '') {
					return null;
				}
				return {
					id: term,
					name: term,
					newTag: true, // add additional parameters
				};
			},
			insertTag: function (data, tag) {
				// Insert the tag at the end of the results
				if (
					jQuery(data).filter(function () {
						return this.name.localeCompare(tag.name) === 0;
					}).length === 0
				) {
					data.push(tag);
				}
			},
		};
		var ajaxOptionsDefault = {
			url: null,
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					q: params.term, // search term
					page: params.page,
				};
			},
			processResults: function (data, params) {
				return {
					results: data,
				};
			},
		};

		// function to triigger change value on selet2 => used when it's needed
		var changeFunction = function (e) {
			if (jQuery(val).parents('form[data-bv-onsuccess]').length > 0) {
				jQuery(val)
					.parents('form')
					.bootstrapValidator(
						'revalidateField',
						jQuery(val).attr('name')
					);
			}
		};
		// tags in create content
		if (jQuery(val).parent('.form-group_select2Ajax').length > 0) {
			select2options.ajax = ajaxOptionsDefault;
			select2options.ajax.url = wpApiSettings.root + 'tags/';
			select2options.tags = true;
			select2options.minimumInputLength = 1;
			select2options.templateResult = formaResultTags;
			select2options.templateSelection = formatResultSelectionTags;
		}
		// user bill in create group
		if (jQuery(val).parent('.form-group-member').length > 0) {
			select2options.minimumInputLength = 1;
			select2options.ajax = ajaxOptionsDefault;
			select2options.ajax.url = wpApiSettings.root + 'facilitators/';
			select2options.templateResult = formaResult;
			select2options.templateSelection = formatResultSelection;
		}
		// init select2 after detect needed options on every select2
		jQuery(val).select2(select2options);

		// add placeholder to search box
		// .on('select2:opening', function(e) {
		// 	// add placeholder to search box
		// 	jQuery(this)
		// 		.data('select2')
		// 		.$dropdown.find(':input.select2-search__field')
		// 		.attr('placeholder', searchPlaceholder);
		// })
	});
}

function openGroupFolder() {
	if (jQuery('.section-wrapper').length >= 1) {
		jQuery('.section-wrapper').toggleClass('folder-opened');
	}
}
function formaResult(urlResult) {
	if (urlResult.loading) {
		return urlResult.text;
	}
	// urlResult.avatar_url
	var userResultContainer = jQuery(
		// info preview component
		'<div class="info-preview"><div class="avatar avatar-sm"></div><div class="info info-sm"><h4 class="info-title"></h4></div>'
		// end of info preview component
	);

	if (urlResult.url !== '') {
		userResultContainer.find('.avatar').css({
			'background-image': 'url(' + urlResult.url + ')',
			'background-size': 'cover',
		});
	}

	if (urlResult.name !== '') {
		userResultContainer.find('.info-title').text(urlResult.name);
	}

	return userResultContainer;
}

function formatResultSelection(urlResult) {
	var userSelection = jQuery(
			'<div class="user-bill"><div class="avatar avatar-xxs"></div><p></p></div>'
		),
		name,
		url;

	if (!urlResult.name) {
		name = urlResult.element.dataset.name;
		url = urlResult.element.dataset.url;
	} else {
		if (urlResult.url !== '') {
			url = urlResult.url;
			userSelection.find('.avatar').css({
				'background-image': 'url(' + url + ')',
				'background-size': 'cover',
			});
		}
		if (urlResult.name !== '') {
			name = urlResult.name;
		}
	}

	userSelection.find('p').text(name);
	return userSelection;
}
function formaResultTags(urlResult) {
	if (urlResult.loading) {
		return urlResult.text;
	}
	var userResultContainer = jQuery(
		// info preview component
		'<div class="info-preview"><div class="info info-sm"><h4 class="info-title"></h4></div>'
		// end of info preview component
	);

	if (urlResult.name !== '') {
		userResultContainer.find('.info-title').text(urlResult.name);
	}

	return userResultContainer;
}

function formatResultSelectionTags(urlResult) {
	var userSelection = jQuery('<div class="user-bill"><p></p></div>');
	if (urlResult.name !== '' && urlResult.name !== undefined) {
		userSelection.find('p').text('# ' + urlResult.name);
	} else {
		userSelection.find('p').text('# ' + urlResult.text);
	}
	return userSelection;
}

function uppyUpLoader() {
	var FileInput = Uppy.FileInput;
	var DragDrop = Uppy.DragDrop;

	if (
		jQuery('.new-group .modal-body .new-content_info>div:not(.bg-primary)')
			.length > 0
	) {
		var uppyMo = Uppy.Core({
			id: 'groupPhoto',
			allowMultipleUploads: true,
			debug: true,
			restrictions: {
				maxNumberOfFiles: 1,
				allowedFileTypes: ['image/jpeg', 'image/png'],
			},
		})
			.use(FileInput, {
				target: '.new-group .new-content_info>div:not(.bg-primary)',
				pretty: true,
				inputName: 'groupPhoto',
			})
			.on('file-added', function (file) {
				jQuery(
					'.new-group .modal-body .new-content_info>div:not(.bg-primary)'
				).addClass('file-choosen');

				var reader = new FileReader();

				reader.onload = function (e) {
					jQuery(
						'.new-group .modal-body .new-content_info .avatar'
					).data('avatar', e.target.result);
					avatarInit();
				};

				reader.readAsDataURL(
					jQuery(
						'.new-group .new-content_info>div:not(.bg-primary) input'
					)[0].files[0]
				);
			});
	}
	if (
		jQuery('.preview-card .avatar:not(.group-photo) .change-photo').length >
		0
	) {
		var uppyMo = Uppy.Core({
			id: 'userPhoto',
			allowMultipleUploads: true,
			debug: true,
			restrictions: {
				maxNumberOfFiles: 1,
				allowedFileTypes: ['image/jpeg', 'image/png'],
			},
		})
			.use(FileInput, {
				target: '.preview-card .avatar .change-photo',
				pretty: true,
				inputName: 'userPhoto',
			})
			.on('file-added', function (file) {
				var reader = new FileReader();

				reader.onload = function (e) {
					jQuery('.preview-card .avatar').data(
						'avatar',
						e.target.result
					);
					jQuery('.preview-card .avatar')[0].style.setProperty('background-size', 'cover', 'important');
					avatarInit();
				};

				reader.readAsDataURL(
					jQuery('.preview-card .change-photo input')[0].files[0]
				);
			});
	}
	if (jQuery('.preview-card .avatar.group-photo .change-photo').length > 0) {
		var uppyMo = Uppy.Core({
			id: 'groupPhotoPreview',
			allowMultipleUploads: true,
			debug: true,
			restrictions: {
				maxNumberOfFiles: 1,
				allowedFileTypes: ['image/jpeg', 'image/png'],
			},
		})
			.use(FileInput, {
				target: '.preview-card .avatar .change-photo',
				pretty: true,
				inputName: 'userPhoto',
			})
			.on('file-added', function (file) {
				var reader = new FileReader();

				reader.onload = function (e) {
					jQuery('.preview-card .avatar').data(
						'avatar',
						e.target.result
					);
					avatarInit();
				};

				reader.readAsDataURL(
					jQuery('.preview-card .change-photo input')[0].files[0]
				);
			});
	}

	if (jQuery('#pc').length > 0) {
		var uppyPC = Uppy.Core({
			id: 'attachPc',
			allowMultipleUploads: true,
			debug: true,
			restrictions: {
				maxNumberOfFiles: null,
				allowedFileTypes: [
					'.pdf',
					'.gz',
					'.doc',
					'.docx',
					'.txt',
					'.xlsx',
					'.rtf',
					'.png',
					'.jpg',
				],
			},
		})
			// .use(FileInput, {
			// 	target: '#pc',
			// 	inputName: 'attachPc',
			// })
			.use(DragDrop, {
				target: '#pc',
				inputName: 'attachPc',
			})
			.on('file-added', function (file) {
				var fileName = file.name,
					fileExe = file.extension,
					fileSize = Math.round(file.size / 1024),
					fileSection = jQuery(
						'<div class="wrapper-file-added"><div class="file-added"><p class="exe">' +
							fileExe +
							'</p><div><p>' +
							fileName +
							'</p><span>' +
							fileSize +
							' kb</span></div></div><div><a href="#" class="btn btn-secondary btn-upload-attach"> <i class="icon-upload"></i> <span>رفع</span> </a><a href="#" class="btn btn-close"> <i class="icon-close"></i> <span>الغاء</span> </a></div></div>'
					);

				jQuery('#addAttach').append(fileSection);
			});
	}
	// if (jQuery('#dropbox').length > 0) {
	// 	var uppyDropbox = Uppy.Core({
	// 		id: 'attachDropbox',
	// 		allowMultipleUploads: true,
	// 		debug: true,
	// 		restrictions: {
	// 			maxNumberOfFiles: 1
	// 			// allowedFileTypes: ['image/jpeg', 'image/png']
	// 		}
	// 	}).use(Dropbox, {
	// 		target: '#dropbox',
	// 		pretty: true,
	// 		companionUrl: 'http://0.0.0.0:3020',
	// 		inputName: 'attachDropbox'
	// 	});
	// }
	// http://localhost/mowazi/wp-content/uploads/

	// var uppyDrive = Uppy.Core({
	// 	id: 'attachdrive',
	// 	allowMultipleUploads: true,
	// 	debug: true,
	// 	restrictions: {
	// 		maxNumberOfFiles: 1
	// 		// allowedFileTypes: ['image/jpeg', 'image/png']
	// 	}
	// })
	// 	.use(GoogleDrive, {
	// 		target: '#dropbox',
	// 		title: 'Google Drive',
	// 		// companionUrl: 'http://companion.uppy.io',
	// 		pretty: true,
	// 		inputName: 'attachDropbox'
	// 	})
}

function setWindowHistory(prefix, perma, url, data) {
	if (data.signal) {
		data.signal = 'undefined';
	}

	// if the request body had formData in it delete it to prevent js error becuase FormData not allowed to be cloned
	if (data.body instanceof FormData) {
		delete data.body;
	}
	var state = {
		url: url,
		data: data,
	};
	document.title = prefix + wpApiSettings.sitename;
	window.history.pushState(state, prefix, perma);

	if (!document.querySelector('#nav_wrap .nav-link.active')) {
		jQuery('body')[0].className = jQuery('body')[0].className.replace(
			/\bbg.*?\b/g,
			''
		);
	}
	if (jQuery('.view-content_container').length == 1) {
		jQuery('body')[0].className = jQuery('body')[0].className.replace(
			/\bbg.*?\b/g,
			''
		);
	}
}

function formDateString(formid) {
	var form = jQuery('#' + formid),
		day = form.find('select[name="day"]').val(),
		month = form.find('select[name="month"]').val(),
		year = form.find('select[name="year"]').val(),
		date = day + '/' + month + '/' + year;

	form.find('input[name="bdate"]').val(date);
	form.bootstrapValidator('revalidateField', 'bdate');
}

// helper function to get the closest parent element matching a selector, using ele.closest with a polyfill to support older browsers
function get_closest_parent(el, selector) {
	// polyfill
	if (!Element.prototype.matches) {
		Element.prototype.matches =
			Element.prototype.msMatchesSelector ||
			Element.prototype.webkitMatchesSelector;
	}

	if (!Element.prototype.closest) {
		Element.prototype.closest = function (s) {
			var el = this;

			do {
				if (el.matches(s)) return el;
				el = el.parentElement || el.parentNode;
			} while (el !== null && el.nodeType === 1);
			return null;
		};
	}
	// end polyfill
	var parent = el.closest(selector);

	return parent;
}

// return validate path to validate username
function getValidateEmailUrl() {
	var urlUsername = wpApiSettings.root + 'validate-username',
		urlEmailNumber = wpApiSettings.root + 'validate-emailnumber';

	if (jQuery('#formRegister').length !== 0) {
		jQuery('#formRegister')
			.data('bootstrapValidator')
			.updateOption('username', 'remote', 'url', urlUsername)
			.updateOption('username', 'remote', 'delay', '1000')
			.updateOption('email', 'remote', 'url', urlEmailNumber)
			.updateOption('email', 'remote', 'delay', '1000')
			.updateOption('number', 'remote', 'url', urlEmailNumber)
			.updateOption('number', 'remote', 'delay', '1000');
	}
}
// function to work when it's activity
function activityCreation(rowsJson, returnStatus, index) {
	var stamp = 'panel_' + new Date().getTime(),
		mainComponent = jQuery(
			'<div class="workshop_partition_content whiteblue-color" id="' +
				stamp +
				'"><div class="header handle"><div><a href="#"><i class="icon-drag"></i></a><span>نشاط</span></div><div><button onclick="toggleExpand(this)" class="expand-collapse-component"><i class="icon-notes"></i>expand/collapse item</button><a href="#notesSidebar"><i class="icon-notes"></i></a><a href="#commentsSidebar"><i class="icon-comment"></i></a><a href="#materialSidebar"><i class="icon-material"></i></a><a href="#attachesSidebar"><i class="icon-sources-alt"></i></a><a href="#" title="delete entry" class="delete-entry"><i class="icon-delete"></i></a></div></div><div class="workshop-content"><div class="p-0"><form data-bv-live="disabled"></form><div class="row no-gutters default"><div class="col-md-1"><input class="form-control workshop-input workshop-input_number" placeholder="0"></div><div class="col-md-3"><textarea class="form-control workshop-input workshop-input_title" placeholder="عنوان"></textarea></div><div class="col-md-6"><textarea class="form-control workshop-input workshop-input_content" placeholder="تفاصيل"></textarea></div><div class="col-md-2"><div class="form-group"><textarea class="form-control workshop-input workshop-input_notes" placeholder="ملاحظات"></textarea></div></div></div></div></div></div></div>'
		),
		sidebarWorkshop = jQuery(
			'<a " href="#" class="workshop_partition whiteblue-color"data-panel="' +
				stamp +
				'"><span class="get-time">0</span><span class="get-text">نشاط</span><i class="icon-tringle-down"></i></a>'
		);
	// create rows dynamically if it's available
	if (rowsJson) {
		// check if there's rows
		rowsJson.forEach(function (arrayItem, index) {
			var addRow = jQuery(
				'<div class="row no-gutters"><div class="col-md-1 d-flex justify-content-center align-items-center flex-column"><a class="incMin" href="#"><i class="icon-plus"></i></a><div class="form-group"><input value="' +
					arrayItem.duration +
					'" type="text" class="form-control workshop-input workshop-input_number" name="time_' +
					index +
					'_' +
					stamp +
					'" maxlength="3" placeholder="0" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></div><a class="decMin" href="#"><i class="icon-minus"></i></a></div><div class="col-md-3"><div class="form-group"><textarea class="form-control workshop-input workshop-input_title" name="title_' +
					index +
					'_' +
					stamp +
					'" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">' +
					arrayItem.title +
					'</textarea></div></div><div class="col-md-6"><div class="form-group"><textarea class="form-control workshop-input workshop-input_content" name="content_' +
					index +
					'_' +
					stamp +
					'" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">' +
					arrayItem.desc +
					'</textarea></div></div><div class="col-md-2"><div class="form-group"><textarea class="form-control workshop-input workshop-input_notes" name="notes_' +
					index +
					'_' +
					stamp +
					'" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></textarea></div></div></div>'
			);
			// if there's note
			if (arrayItem.note) {
				addRow = jQuery(
					'<div class="row no-gutters"><div class="col-md-1 d-flex justify-content-center align-items-center flex-column"><a class="incMin" href="#"><i class="icon-plus"></i></a><div class="form-group"><input value="' +
						arrayItem.duration +
						'" type="text" class="form-control workshop-input workshop-input_number" name="time_' +
						index +
						'_' +
						stamp +
						'" maxlength="3" placeholder="0" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></div><a class="decMin" href="#"><i class="icon-minus"></i></a></div><div class="col-md-3"><div class="form-group"><textarea class="form-control workshop-input workshop-input_title" name="title_' +
						index +
						'_' +
						stamp +
						'" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">' +
						arrayItem.title +
						'</textarea></div></div><div class="col-md-6"><div class="form-group"><textarea class="form-control workshop-input workshop-input_content" name="content_' +
						index +
						'_' +
						stamp +
						'" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">' +
						arrayItem.desc +
						'</textarea></div></div><div class="col-md-2"><div class="form-group"><textarea class="form-control workshop-input workshop-input_notes" name="notes_' +
						index +
						'_' +
						stamp +
						'" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">' +
						arrayItem.note +
						'</textarea></div></div></div>'
				);
			}
			// rowsDuration = parseInt(arrayItem.duration);
			// console.log(duration);

			mainComponent.find('form').append(addRow);
		});
	}

	// append main component to active day

	// validate only numbers on number textarea
	validateNumbers('.workshop-input_number');
	// validate form
	bsValidatorInit();
	// return or append
	if (!returnStatus) {
		jQuery('main .workshop-content_wrapper').append(mainComponent);
		// append sidebar workshop
		jQuery('main .right-side_info .workshop-wrapper').append(
			sidebarWorkshop
		);
	} else {
		jQuery(
			'main .right-side_info .workshop-wrapper div.d-block[data-mo-target]'
		).append(sidebarWorkshop);
		indexStr = index.toString();
		if (indexStr) {
			var indexNum = parseInt(indexStr);
			jQuery(
				jQuery(
					'main .right-side_info .workshop-wrapper div.d-block[data-mo-target] > a'
				)[indexNum]
			).before(sidebarWorkshop);
		}

		return mainComponent;
	}
}
// function for drag & drop activities
function dragDrop() {
	// init drag & drop plugin
	var dragulaInit = dragula({
		direction: 'vertical',
		copy: function (el, source) {
			if (jQuery(source).hasClass('tab-pane')) {
				return false;
			} else {
				return hasClasse(el, 'mz-mb-35');
			}
		},
		accepts: function (el, target, source) {
			if (jQuery(target).hasClass('tab-pane')) {
				return true;
			}
		},
		moves: function (el, container, handle) {
			jQuery(el).find('.stretched-link').addClass('handle');
			return hasClasse(handle, 'handle');

			return true;
		},
		isContainer: function (el) {
			return el.classList.contains('drag-option');
		},
		invalid: function (el, handle) {
			return el.classList.contains('nodrag');
		},
		revertOnSpill: true,
	})
		.on('drop', function (el, target, source, sibling) {
			var eleIndex = jQuery(el).index();
			var path = 'fetch-activity/',
				url =
					wpApiSettings.root +
					path +
					'?q=' +
					jQuery(el).find('.stretched-link').data('id');

			if (jQuery(source).hasClass('container-wrapper')) {
				jQuery(el).addClass('element-loading');
				fetch(url, {
					headers: {
						'Content-Type': 'application/json',
					},
				})
					.then(function (response) {
						callLoading('off', 'on');

						if (response.status == 500) {
							// trigger catch block
							throw new Error(response.statusText);
						} else {
							return response.json();
						}
					})
					.then(function (data) {
						var activityPanel = activityCreation(
							data,
							true,
							eleIndex
						);

						jQuery(el)
							.html(activityPanel)
							.removeClass('element-loading');
						bsValidatorInit();

						jQuery('input.workshop-input_number').trigger('change');

						var inputsInside = document.querySelectorAll(
							'.workshop-input_content'
						);

						jQuery.each(inputsInside, function (index, val) {
							autoExpand(val);
						});
					})
					.catch(function (error) {
						if (error.name !== 'AbortError') {
						}
					});
			}
			// rearrange sidebar
			var eleOldIndex = el.dataset.index,
				eleId = jQuery(el).attr('id')
					? jQuery(el).attr('id')
					: jQuery(el).find('.workshop_partition_content').attr('id');
			elementSideBar = jQuery(
				'main .right-side_info .workshop-wrapper .d-block[data-mo-target]'
			).find('.workshop_partition[data-panel="' + eleId + '"]');

			// detect old index
			if (eleOldIndex < eleIndex) {
				jQuery(
					jQuery(
						'main .right-side_info .workshop-wrapper div.d-block[data-mo-target] > a'
					)[eleIndex]
				).after(elementSideBar);
			} else {
				jQuery(
					jQuery(
						'main .right-side_info .workshop-wrapper div.d-block[data-mo-target] > a'
					)[eleIndex]
				).before(elementSideBar);
			}
		})
		.on('drag', function (el, source) {
			// set old index on element
			if (jQuery(source).hasClass('tab-pane')) {
				el.dataset.index = jQuery(el).index();
			}
		});
}
/* function to on & off loading */
function callLoading(statue, scrollStatue) {
	if (
		scrollStatue == null ||
		scrollStatue == 'undefined' ||
		scrollStatue == 'false'
	) {
		var scrollStatue = 'off';
	}
	if (statue == 'on') {
		jQuery('.loading-wrapper').removeClass('d-none');
	} else {
		jQuery('.loading-wrapper').addClass('d-none');
		if (scrollStatue == 'on') {
			jQuery('html').animate({ scrollTop: 0 }, 550);
		}
	}
}
function toastInit(toastClass, toastMsg) {
	var postioningToast = jQuery('.postioning-toast'),
		toastsRemaining = jQuery('[class*="toast_"]').length,
		toastIndex = toastsRemaining + 1,
		toastSelector = 'toast_' + toastIndex,
		toast;

	if (toastClass == 'error_toast') {
		toast = jQuery(
			'<div class="fade ' +
				toastSelector +
				' toast-style ' +
				toastClass +
				'" role="alert" aria-live="assertive" data-delay="10000" aria-atomic="true"><div class="toast-body"><i class="icon-close"></i>' +
				toastMsg +
				'</div></div>'
		);
	} else {
		toast = jQuery(
			'<div class="fade ' +
				toastSelector +
				' toast-style ' +
				toastClass +
				'" role="alert" aria-live="assertive" data-delay="5000" aria-atomic="true"><div class="toast-body"><i class="icon-check"></i>' +
				toastMsg +
				'</div></div>'
		);
	}
	// <button type="button" class="close close-toast" data-dismiss="toast" aria-label="Close"><span aria-hidden="false">&times;</span></button>

	postioningToast.append(toast);

	jQuery('.' + toastSelector).toast('show');

	// variation handle
	jQuery('.' + toastSelector).on('hidden.bs.toast', function () {
		jQuery(this).remove();
	});
}
// function isInViewport(elem) {
// 	if (elem) {
// 		var bounding = elem.getBoundingClientRect();
// 		return (
// 			bounding.top >= 0 &&
// 			bounding.left >= 0 &&
// 			bounding.bottom <=
// 				(window.innerHeight || document.documentElement.clientHeight) &&
// 			bounding.right <=
// 				(window.innerWidth || document.documentElement.clientWidth)
// 		);
// 	}
// }