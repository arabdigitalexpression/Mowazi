var main = document.getElementById('content_wrap'),
	nav = document.getElementById('nav_wrap'),
	controller = null;

domready(function () {
	// reload page on back or forward button pressed
	window.addEventListener('popstate', function (e) {
		// if (e.state == null) {
		window.location.reload();
		// }
	});

	// attach get page listner
	(function () {
		var links = document.querySelectorAll('[data-page]');
		for (var i = links.length - 1; i >= 0; i--) {
			links[i].addEventListener('click', getPage);
		}
	})();

	// attach submit create post forms
	(function () {
		var links = document.querySelectorAll('.create-post');
		for (var i = links.length - 1; i >= 0; i--) {
			links[i].addEventListener('click', createPost);
		}
	})();
	// attach submit create post forms
	(function () {
		var links = document.querySelectorAll('.remove-material');
		for (var i = links.length - 1; i >= 0; i--) {
			links[i].addEventListener('click', removeMatrial);
		}
	})();

	// (function () {
	// 	var links = document.querySelectorAll('#settings .btn.btn-secondary');
	// 	for (var i = links.length - 1; i >= 0; i--) {
	// 		links[i].addEventListener('click', accSetting);
	// 	}
	// })();

	// attach submit create post forms
	(function () {
		var links = document.querySelectorAll('.publish-post');
		for (var i = links.length - 1; i >= 0; i--) {
			links[i].addEventListener('click', publishWorkshop);
		}
	})();

	// attach get profile page listner
	(function () {
		var links = document.querySelectorAll('.get-profile');
		for (var i = links.length - 1; i >= 0; i--) {
			links[i].addEventListener('click', getProfile);
		}
	})();

	// attach get archive listner
	(function () {
		var links = document.querySelectorAll('[data-archive]');
		for (var i = links.length - 1; i >= 0; i--) {
			links[i].addEventListener('click', getArchive);
		}
	})();

	// attach bookmark listner
	(function () {
		var links = document.querySelectorAll('.bookmark');
		for (var i = links.length - 1; i >= 0; i--) {
			links[i].addEventListener('click', bookmarkPost);
		}
	})();

	// attach clone listner
	(function () {
		var links = document.querySelectorAll('.clone');
		for (var i = links.length - 1; i >= 0; i--) {
			links[i].addEventListener('click', clonePost);
		}
	})();

	// attach get single post listner
	(function () {
		var links = document.querySelectorAll('.get-post');
		for (var i = links.length - 1; i >= 0; i--) {
			links[i].addEventListener('click', getPost);
		}
	})();

	// attach logout listner
	(function () {
		var links = document.querySelectorAll('.logout');
		for (var i = links.length - 1; i >= 0; i--) {
			links[i].addEventListener('click', logoutUser);
		}
	})();

	// attach load all listner
	(function () {
		var links = document.querySelectorAll('[data-load]');
		for (var i = links.length - 1; i >= 0; i--) {
			links[i].addEventListener('click', loadAllPosts);
		}
	})();

	// attach get tag archive listner
	(function () {
		var links = document.querySelectorAll('[data-t]');
		for (var i = links.length - 1; i >= 0; i--) {
			links[i].addEventListener('click', getTagArchive);
		}
	})();

	// attach notification read all listner
	(function () {
		var links = document.querySelectorAll('.read-all');
		for (var i = links.length - 1; i >= 0; i--) {
			links[i].addEventListener('click', notifiReadAll);
		}
	})();

	// end dom ready
});

// get page
function getPage(e) {
	e.preventDefault();
	e.stopImmediatePropagation();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var el = e.target.hasAttribute('data-page')
			? e.target
			: get_closest_parent(e.target, '[data-page]'),
		path = 'page/',
		url = wpApiSettings.root + path,
		page = el.dataset.page,
		u = document.querySelector('body[data-u]').dataset.u,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				u: u,
				page: page,
			}),
		};

	callLoading('on');

	fetch(url, request)
		.then(function (response) {
			callLoading('off', 'on');

			if (!response.ok) {
				// trigger catch block
				throw new Error(response.statusText);
			} else {
				return response.json();
			}
		})
		.then(function (data) {
			main.innerHTML = data.html;
			nav.innerHTML = data.nav;

			addListener('[data-page]', 'click', getPage);
			addListener('[data-archive]', 'click', getArchive);
			setWindowHistory(data.title, data.perma, url, request);
			select2dropDown();
			bsValidatorInit();
			getValidateEmailUrl();
			removeClasse(nav, 'relative-header');
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// register user
function registerUser(e) {
	e.preventDefault();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var inputs = document.getElementById('formRegister').elements,
		u = document.querySelector('body[data-u]').dataset.u,
		path = 'register/',
		url = wpApiSettings.root + path,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				username: inputs['username'].value,
				password: inputs['password'].value,
				//fullname: inputs['firstname'].value +' '+inputs['lastname'].value,
				fullname: inputs['username'].value,
				//number: inputs['number'].value,
				email: inputs['email'].value,
				//bdate: inputs['bdate'].value,
				u: u,
			}),
		};

	callLoading('on');

	fetch(url, request)
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
			//console.log(data);
			// document.location.replace(data.url);
			window.history.pushState('', '', data.url);
			window.location.reload();
			toastInit('success_toast', data.message);
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// user login
function loginUser(e) {
	e.preventDefault();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var inputs = document.getElementById('formLogin').elements,
		path = 'login/',
		url = wpApiSettings.root + path,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				username: inputs['username'].value,
				password: inputs['password'].value,
			}),
		};

	callLoading('on');

	fetch(url, request)
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
			//console.log(data);
			if (data.data && data.data.status !== 200) {
				toastInit('error_toast', data.message);
			} else {
				if (data.url) {
					// document.location.replace(data.url);
					toastInit('success_toast', data.message);
					window.history.pushState('', '', data.url);
					window.location.reload();
				}
			}
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}
function regeneratePass(e) {
	e.preventDefault();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var inputs = document.getElementById('formRegeneratePass').elements,
		path = 'forget-pw/',
		url = wpApiSettings.root + path,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				email: inputs['email'].value
			}),
		};

	callLoading('on');

	fetch(url, request)
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
			//console.log(data);
			if (data.data && data.data.status !== 200) {
				toastInit('error_toast', data.message);
			} else {
				if (data.url) {
					// document.location.replace(data.url);
					toastInit('success_toast', data.message);
					// window.history.pushState('', '', data.url);
					// window.location.reload();
				}
			}
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// user logout
function logoutUser(e) {
	e.preventDefault();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var u = document.querySelector('body[data-u]').dataset.u,
		path = 'logout/',
		url = wpApiSettings.root + path,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': wpApiSettings.nonce,
			},
			body: JSON.stringify({
				u: u,
			}),
		};

	callLoading('on');

	fetch(url, request)
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
			//console.log(data);
			if (data.url) {
				document.location.replace(data.url);
				toastInit('success_toast', data.message);
			}
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// create post
function createPost(e) {
	e.preventDefault();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var form = get_closest_parent(e.target, '#NewPost').querySelector(
		'.tab-pane.active form'
	);

	jQuery(form).data('bootstrapValidator').validate();

	if (jQuery(form).data('bootstrapValidator').isValid()) {
		var inputs = form.elements,
			post = form.dataset.post,
			u = document.querySelector('body[data-u]').dataset.u,
			path = 'create-post/',
			url = wpApiSettings.root + path,
			request_body = {
				post: post,
				u: u,
			};
		for (var i = inputs.length - 1; i >= 0; i--) {
			if (
				inputs[i].type !== 'submit' &&
				inputs[i].type !== 'search' &&
				inputs[i].type !== 'select-multiple'
			) {
				request_body[inputs[i].name] = inputs[i].value;
			} else if (inputs[i].name.includes('Tags')) {
				var sel = inputs[i],
					opts = [];

				for (var x = 0; x < sel.options.length; x++) {
					opt = sel.options[x];
					opt_info = {};

					if (opt.selected) {
						opt_info['value'] = opt.value;
						opt_info['new'] = opt.dataset.select2Tag ? true : false;
						opts.push(opt_info);
					}
				}

				request_body['tags'] = opts;
			}
			if( inputs[i].name == 'workshopActivities'){
				var sel = inputs[i],
					opts = [];

				for (var x = 0; x < sel.options.length; x++) {
					opt = sel.options[x];
					// opt_info = {};

					if (opt.selected) {
						opts.push(opt.value);
					}
				}

				request_body['workshopActivities'] = opts;
			}
		}
		// alert(JSON.stringify(request_body));
		var request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': wpApiSettings.nonce,
			},
			body: JSON.stringify(request_body),
		};

		// callLoading('on');

		jQuery('#NewPost').modal('hide');
		fetch(url, request)
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
				if (data.data && data.data.status !== 200) {
					toastInit('error_toast', data.message);
				} else {
					main.innerHTML = data.html;
					nav.innerHTML = data.nav;
					setWindowHistory(data.title, data.perma, url, request);
					addListener('[data-page]', 'click', getPage);
					addListener('.publish-post', 'click', publishWorkshop);
					if (data.activity) {
						activityCreation();
					}
					jQuery('footer').addClass('d-none');
					tinyInit();
					select2dropDown();
					jQuery('body').addClass('fixed-sidebar');

					if (
						!jQuery('.container-post-wrapper').hasClass(
							'activity-content'
						)
					) {
						jQuery('.btn-days_wrapper a.tab').click();
					}
					toastInit('success_toast', data.message);
				}
				window.location.href=window.location.href+"?c=edit";
			})
			.catch(function (error) {
				if (error.name !== 'AbortError') {
					console.log(error);
					toastInit('error_toast', error);
				}
			});


	}
}

/*function accSetting(e) {
    e.preventDefault();

    // aport any onging fetch ex: loadMore
    if (controller) {
        controller.abort();
    }

    controller = new AbortController();
    var signal = controller.signal;

    var form = get_closest_parent(e.target, '#settings').querySelector('form');

    jQuery(form)
        .data('bootstrapValidator')
        .validate();

    if (
        jQuery(form)
            .data('bootstrapValidator')
            .isValid()
    ) {
        console.log('valid');

        // var request = {
        //  method: 'POST',
        //  mode: 'same-origin',
        //  credentials: 'same-origin',
        //  signal: signal,
        //  headers: {
        //      'Content-Type': 'application/json',
        //      'X-WP-Nonce': wpApiSettings.nonce
        //  },
        //  body: JSON.stringify(request_body)
        // };
        // callLoading('on');
        // fetch(url, request)
        //  .then(function(response) {
        //      callLoading('off', 'on');
        //      if (response.status == 500) {
        //          // trigger catch block
        //          throw new Error(response.statusText);
        //      } else {
        //          return response.json();
        //      }
        //  })
        //  .then(function(data) {
        //      console.log(data);
        // toastInit('success_toast', 'تم انشاء حساب جديد')
        //  })
        //  .catch(function(error) {
        //      if (error.name !== 'AbortError') {
        //          console.log(error);
        // toastInit('error_toast', 'حدث خطأ ما، تأكد من صحة البيانات');
        //      }
        //  });
    }
}*/

// create group
function createGroup(e) {
	e.preventDefault();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var form = e.target,
		formData = new FormData(),
		memberSelect = form.querySelector('select[name="members"]'),
		adminSelect = form.querySelector('select[name="admins"]');

	formData.append('u', document.querySelector('body[data-u]').dataset.u);
	formData.append('title', form.querySelector('input[name="title"]').value);
	formData.append('desc', form.querySelector('textarea[name="desc"]').value);
	window.groupPhoto.getFiles().length !== 0
		? formData.append('groupPhoto', window.groupPhoto.getFiles()[0].data)
		: formData.append('groupPhoto', false);

	for (var x = 0; x < memberSelect.options.length; x++) {
		var opt = memberSelect.options[x];

		if (opt.selected) {
			formData.append('members[]', opt.value);
		}
	}

	for (var x = 0; x < adminSelect.options.length; x++) {
		var opt = adminSelect.options[x];

		if (opt.selected) {
			formData.append('admins[]', opt.value);
		}
	}

	var u = document.querySelector('body[data-u]').dataset.u,
		path = 'create-group/',
		url = wpApiSettings.root + path,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			body: formData,
		};

	fetch(url, request)
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
			//console.log(data);
			jQuery('#newGroup').modal('hide');
			main.innerHTML = data.html;
			avatarInit();
			uppyUpLoader();
			setWindowHistory(data.title, data.perma, url, request);
			toastInit('success_toast', data.message);
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// update group
function updateGroup(e) {
	e.preventDefault();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var form = e.target,
		formData = new FormData(),
		memberSelect = form.querySelector('select[name="members"]'),
		adminSelect = form.querySelector('select[name="admins"]');

	formData.append('u', document.querySelector('body[data-u]').dataset.u);
	formData.append('g', form.dataset.g);
	formData.append('title', form.querySelector('input[name="title"]').value);
	formData.append('desc', form.querySelector('textarea[name="desc"]').value);

	if (window.groupPhotoPreview) {
		window.groupPhotoPreview.getFiles().length !== 0
			? formData.append(
					'groupPhoto',
					window.groupPhotoPreview.getFiles()[0].data
			  )
			: formData.append('groupPhoto', false);
	} else {
		formData.append('groupPhoto', false);
	}

	for (var x = 0; x < memberSelect.options.length; x++) {
		var opt = memberSelect.options[x];

		if (opt.selected) {
			formData.append('members[]', opt.value);
		}
	}

	for (var x = 0; x < adminSelect.options.length; x++) {
		var opt = adminSelect.options[x];

		if (opt.selected) {
			formData.append('admins[]', opt.value);
		}
	}

	var u = document.querySelector('body[data-u]').dataset.u,
		path = 'update-group/',
		url = wpApiSettings.root + path,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			body: formData,
		};

	fetch(url, request)
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
			if (data.data && data.data.status !== 200) {
				toastInit('error_toast', data.message);
			} else {
				toastInit('success_toast', data.message);
			}
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

function publishWorkshop(e) {
	e.preventDefault();

	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var inputs = document.getElementById('formPublishWorkshop').elements,
		post = document.getElementById('formPublishWorkshop').dataset.post,
		tinyEl = jQuery('textarea#tiny'),
		tinyPost =
			tinyEl.length !== 0 ? jQuery('textarea#tiny').tinymce() : false,
		content = !tinyPost ? '' : tinyPost.getContent(),
		headlines = {},
		headlines_elements = document.querySelectorAll(
			'.right-side_info .article-title'
		),
		days = {},
		days_elements = document.querySelectorAll(
			'.btn-days_wrapper a.btn:not(.tab)'
		),
		entries = {},
		entries_elements = document.querySelectorAll(
			'.workshop-content_wrapper .workshop_partition_content'
		),
		el = hasClasse(e.target, '.publish-post') ? e.target : false,
		draft = !el ? 0 : el.dataset.draft,
		path = 'publish-post/',
		url = wpApiSettings.root + path,
		u = document.querySelector('body[data-u]').dataset.u,
		request_body = {
			post: post,
			u: u,
			content: content,
			status: draft,
		};

	if (hasClasse(e.target, 'bv-form')) {
		draft = 0;
	} else {
		el = hasClasse(e.target, 'publish-post')
			? e.target
			: get_closest_parent(e.target, '.publish-post');
		draft = el.dataset.draft;
	}

	request_body.status = draft;

	for (var i = inputs.length - 1; i >= 0; i--) {
		if (
			inputs[i].type !== 'submit' &&
			inputs[i].type !== 'search' &&
			inputs[i].type !== 'select-multiple'
		) {
			request_body[inputs[i].name] = inputs[i].value;
		} else if (
			inputs[i].type == 'select-multiple' &&
			inputs[i].name == 'collaborators'
		) {
			var sel = inputs[i],
				opts = [];

			for (var x = 0; x < sel.options.length; x++) {
				opt = sel.options[x];

				if (opt.selected) {
					opts.push(opt.value);
				}
			}

			request_body[inputs[i].name] = opts;
		} else if (
			inputs[i].type == 'select-multiple' &&
			inputs[i].name == 'tags'
		) {
			var sel = inputs[i],
				opts = [];

			for (var x = 0; x < sel.options.length; x++) {
				opt = sel.options[x];
				opt_info = {};

				if (opt.selected) {
					opt_info['value'] = opt.value;
					opt_info['new'] = opt.dataset.select2Tag ? true : false;
					opts.push(opt_info);
				}
			}

			request_body[inputs[i].name] = opts;
		}
	}

	if (headlines_elements.length !== 0) {
		for (var i = headlines_elements.length - 1; i >= 0; i--) {
			if (headlines_elements[i].dataset.target) {
				headlines[headlines_elements[i].dataset.target] =
					headlines_elements[i].textContent;
			}
		}
	}

	if (days_elements.length !== 0) {
		for (var i = days_elements.length - 1; i >= 0; i--) {
			var dayPost = days_elements[i].dataset.post
					? days_elements[i].dataset.post
					: 0,
				dayText = days_elements[i].innerText,
				dayTarget = days_elements[i].getAttribute('aria-controls');

			days[dayTarget] = {
				post: dayPost,
				title: dayText,
			};
		}

		request_body['days'] = days;
	}

	if (entries_elements.length !== 0) {
		if (
			document.querySelectorAll(
				'.container-post-wrapper.activity-content'
			).length !== 0
		) {
			for (var i = entries_elements.length - 1; i >= 0; i--) {
				var entryPost = entries_elements[i].dataset.post
						? entries_elements[i].dataset.post
						: get_closest_parent(
								entries_elements[i],
								'.container-post__center'
						  ).dataset.post,
					entryParent = get_closest_parent(
						entries_elements[i],
						'.tab-pane'
					)
						? get_closest_parent(entries_elements[i], '.tab-pane')
								.dataset.post
						: 0,
					entryText = entries_elements[i].querySelector(
						'.header div:first-child span'
					).innerText,
					entryTarget = entries_elements[i].getAttribute('id'),
					entryColor = entries_elements[i]
						.getAttribute('class')
						.replace('workshop_partition_content', ''),
					stepsElements = entries_elements[i].querySelectorAll(
						'form .row'
					),
					entrySteps = [];

				if (stepsElements.length !== 0) {
					for (var x = stepsElements.length - 1; x >= 0; x--) {
						var stepDuration = stepsElements[x].querySelector(
								'input.workshop-input_number'
							).value,
							stepTitle = stepsElements[x].querySelector(
								'textarea.workshop-input_title'
							).value,
							stepDesc = stepsElements[x].querySelector(
								'textarea.workshop-input_content'
							).value,
							stepNote = stepsElements[x].querySelector(
								'textarea.workshop-input_notes'
							).value;

						entrySteps[x] = {
							title: stepTitle,
							desc: stepDesc,
							duration: stepDuration,
							note: stepNote,
						};
					}
				}

				entries[entryTarget] = {
					post: entryPost,
					parent: entryParent,
					title: entryText,
					color: entryColor,
					steps: entrySteps,
					order: i,
				};
			}
		} else {
			for (var i = entries_elements.length - 1; i >= 0; i--) {
				var entryPost = entries_elements[i].dataset.post
						? entries_elements[i].dataset.post
						: 0,
					entryParent = get_closest_parent(
						entries_elements[i],
						'.tab-pane'
					).dataset.post
						? get_closest_parent(entries_elements[i], '.tab-pane')
								.dataset.post
						: get_closest_parent(
								entries_elements[i],
								'.tab-pane'
						  ).getAttribute('id'),
					entryText = entries_elements[i].querySelector(
						'.header div:first-child span'
					).innerText,
					entryTarget = entries_elements[i].getAttribute('id'),
					entryColor = entries_elements[i]
						.getAttribute('class')
						.replace('workshop_partition_content', ''),
					stepsElements = entries_elements[i].querySelectorAll(
						'form .row'
					),
					entrySteps = [];

				if (stepsElements.length !== 0) {
					for (var x = stepsElements.length - 1; x >= 0; x--) {
						var stepDuration = stepsElements[x].querySelector(
								'input.workshop-input_number'
							).value,
							stepTitle = stepsElements[x].querySelector(
								'textarea.workshop-input_title'
							).value,
							stepDesc = stepsElements[x].querySelector(
								'textarea.workshop-input_content'
							).value,
							stepNote = stepsElements[x].querySelector(
								'textarea.workshop-input_notes'
							).value;

						entrySteps[x] = {
							title: stepTitle,
							desc: stepDesc,
							duration: stepDuration,
							note: stepNote,
						};
					}
				}

				entries[entryTarget] = {
					post: entryPost,
					parent: entryParent,
					title: entryText,
					color: entryColor,
					steps: entrySteps,
					order: i,
				};
			}
		}

		request_body['entries'] = entries;
	}

	var request = {
		method: 'POST',
		mode: 'same-origin',
		credentials: 'same-origin',
		signal: signal,
		headers: {
			'Content-Type': 'application/json',
			'X-WP-Nonce': wpApiSettings.nonce,
		},
		body: JSON.stringify(request_body),
	};

	callLoading('on');

	fetch(url, request)
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
			//console.log(data);
			jQuery('#editWorkShop').modal('hide');
			toastInit('success_toast', data.message);
			removeClasse(document.querySelector('body'), 'fixed-sidebar');
			main.innerHTML = data.html;
			nav.innerHTML = data.nav;
			setWindowHistory(data.title, data.perma, url, request);

			addListener('.get-profile', 'click', getProfile);
			addListener('[data-archive]', 'click', getArchive);
			addListener('.bookmark', 'click', bookmarkPost);
			addListener('.get-post', 'click', getPost);
			addListener('.logout', 'click', logoutUser);
			addListener('.create-post', 'click', createPost);
			avatarInit();
			select2dropDown();
			bsValidatorInit();
			// document.location.replace(data.url);
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// puplish post
function publishPost(e) {
	e.preventDefault();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var tinyEl = jQuery('textarea#tiny'),
		tinyPost =
			tinyEl.length !== 0 ? jQuery('textarea#tiny').tinymce() : false,
		headlines = {},
		headlines_elements = document.querySelectorAll(
			'.right-side_info .article-title'
		),
		days = {},
		days_elements = document.querySelectorAll(
			'.btn-days_wrapper a.btn:not(.tab)'
		),
		entries = {},
		entries_elements = document.querySelectorAll(
			'.workshop-content_wrapper .workshop_partition_content'
		);

	if (headlines_elements.length !== 0) {
		for (var i = headlines_elements.length - 1; i >= 0; i--) {
			if (headlines_elements[i].dataset.target) {
				headlines[headlines_elements[i].dataset.target] =
					headlines_elements[i].textContent;
			}
		}
	}

	if (days_elements.length !== 0) {
		for (var i = days_elements.length - 1; i >= 0; i--) {
			var dayPost = days_elements[i].dataset.post
					? days_elements[i].dataset.post
					: 0,
				dayText = days_elements[i].innerText,
				dayTarget = days_elements[i].getAttribute('aria-controls');

			days[dayTarget] = {
				post: dayPost,
				title: dayText,
			};
		}
	}

	if (entries_elements.length !== 0) {
		for (var i = entries_elements.length - 1; i >= 0; i--) {
			var entryPost = entries_elements[i].dataset.post
					? entries_elements[i].dataset.post
					: get_closest_parent(
							entries_elements[i],
							'.container-post__center'
					  ).dataset.post,
				entryParent = get_closest_parent(
					entries_elements[i],
					'.tab-pane'
				)
					? get_closest_parent(entries_elements[i], '.tab-pane')
							.dataset.post
					: 0,
				entryText = entries_elements[i].querySelector(
					'.header div:first-child span'
				).innerText,
				entryTarget = entries_elements[i].getAttribute('id'),
				entryColor = entries_elements[i]
					.getAttribute('class')
					.replace('workshop_partition_content', ''),
				stepsElements = entries_elements[i].querySelectorAll(
					'form .row'
				),
				entrySteps = [];

			if (stepsElements.length !== 0) {
				for (var x = stepsElements.length - 1; x >= 0; x--) {
					var stepDuration = stepsElements[x].querySelector(
							'input.workshop-input_number'
						).value,
						stepTitle = stepsElements[x].querySelector(
							'textarea.workshop-input_title'
						).value,
						stepDesc = stepsElements[x].querySelector(
							'textarea.workshop-input_content'
						).value,
						stepNote = stepsElements[x].querySelector(
							'textarea.workshop-input_notes'
						).value;

					entrySteps[x] = {
						title: stepTitle,
						desc: stepDesc,
						duration: stepDuration,
						note: stepNote,
					};
				}
			}

			entries[entryTarget] = {
				post: entryPost,
				parent: entryParent,
				title: entryText,
				color: entryColor,
				steps: entrySteps,
				order: i,
			};
		}
	}

	var el = hasClasse(e.target, '.publish-post')
			? e.target
			: get_closest_parent(e.target, '.publish-post'),
		content = !tinyPost ? '' : tinyPost.getContent(),
		post = el.dataset.post,
		title = document.querySelector('header.header-post input[name="title"]')
			.value,
		u = document.querySelector('body[data-u]').dataset.u,
		draft = typeof el.dataset.draft != 'undefined' ? el.dataset.draft : 0,
		path = 'publish-post/',
		url = wpApiSettings.root + path,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': wpApiSettings.nonce,
			},
			body: JSON.stringify({
				content: content,
				post: post,
				title: title,
				status: draft,
				headlines: headlines,
				days: days,
				entries: entries,
				u: u,
			}),
		};

	callLoading('on');

	fetch(url, request)
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
			if (data.data && data.data.status !== 200) {
				toastInit('error_toast', data.message);
			} else {
				toastInit('success_toast', data.message);
				main.innerHTML = data.html;
				nav.innerHTML = data.nav;
				removeClasse(document.querySelector('body'), 'fixed-sidebar');
				setWindowHistory(data.title, data.perma, url, request);

				addListener('.get-profile', 'click', getProfile);
				addListener('[data-archive]', 'click', getArchive);
				addListener('.bookmark', 'click', bookmarkPost);
				addListener('.get-post', 'click', getPost);
				addListener('.logout', 'click', logoutUser);
				addListener('.create-post', 'click', createPost);
				avatarInit();
				select2dropDown();
				bsValidatorInit();
			}
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// delete post
function deletePost(e) {
	e.preventDefault();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var inputs = document.getElementById('formDelete').elements,
		post = document.getElementById('formDelete').dataset.id,
		u = document.querySelector('body[data-u]').dataset.u,
		el = document.querySelector('a.remove[data-id="' + post + '"]'),
		path = 'delete-post/',
		url = wpApiSettings.root + path,
		request_body = {
			post: post,
			u: u,
		};

	for (var i = inputs.length - 1; i >= 0; i--) {
		if (inputs[i].type !== 'submit' && inputs[i].type !== 'search') {
			request_body[inputs[i].name] = inputs[i].value;
		}
	}

	var request = {
		method: 'POST',
		mode: 'same-origin',
		credentials: 'same-origin',
		signal: signal,
		headers: {
			'Content-Type': 'application/json',
			'X-WP-Nonce': wpApiSettings.nonce,
		},
		body: JSON.stringify(request_body),
	};

	callLoading('on');

	fetch(url, request)
		.then(function (response) {
			callLoading('off', 'on');
			jQuery('#deletePost').modal('hide');

			if (response.status == 500) {
				// trigger catch block
				throw new Error(response.statusText);
			} else {
				return response.json();
			}
		})
		.then(function (data) {
			if (data.data && data.data.status !== 200) {
				toastInit('error_toast', data.message);
			} else {
				//console.log(data);
				// document.location.replace(data.url);
				toastInit('success_toast', data.message);
				get_closest_parent(el, '.mz-mb-35').remove();
			}
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// report post
function reportPost(e) {
	e.preventDefault();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var inputs = document.getElementById('formReport').elements,
		post = document.getElementById('formReport').dataset.id,
		u = document.querySelector('body[data-u]').dataset.u,
		el = document.querySelector('a.report-btn[data-id="' + post + '"]'),
		path = 'report-post/',
		url = wpApiSettings.root + path,
		request_body = {
			post: post,
			u: u,
		};

	for (var i = inputs.length - 1; i >= 0; i--) {
		if (inputs[i].type !== 'submit' && inputs[i].type !== 'search') {
			request_body[inputs[i].name] = inputs[i].value;
		}
	}

	var request = {
		method: 'POST',
		mode: 'same-origin',
		credentials: 'same-origin',
		signal: signal,
		headers: {
			'Content-Type': 'application/json',
			'X-WP-Nonce': wpApiSettings.nonce,
		},
		body: JSON.stringify(request_body),
	};

	callLoading('on');

	fetch(url, request)
		.then(function (response) {
			callLoading('off', 'on');
			jQuery('#reportPost').modal('hide');

			if (response.status == 500) {
				// trigger catch block
				throw new Error(response.statusText);
			} else {
				return response.json();
			}
		})
		.then(function (data) {
			if (data.data && data.data.status !== 200) {
				toastInit('error_toast', data.message);
			} else {
				toastInit('success_toast', data.message);
				el.remove();
				document.getElementById('reportPost').remove();
			}
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// get post
function getPost(e) {
	e.preventDefault();
	e.stopImmediatePropagation();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var el = hasClasse(e.target, '.get-post')
			? e.target
			: get_closest_parent(e.target, '.get-post'),
		path = 'post/',
		url = wpApiSettings.root + path,
		post = el.dataset.id,
		context = el.dataset.c,
		u = document.querySelector('body[data-u]').dataset.u,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				u: u,
				p: post,
				c: context,
			}),
		};

	callLoading('on');

	fetch(url, request)
		.then(function (response) {
			callLoading('off', 'on');

			if (!response.ok) {
				// trigger catch block
				throw new Error(response.statusText);
			} else {
				return response.json();
			}
		})
		.then(function (data) {
			//console.log(data);
			main.innerHTML = data.html;

			if (data.nav) {
				nav.innerHTML = data.nav;
				tinyInit();
			}

			setWindowHistory(data.title, data.perma, url, request);
			addListener('.publish-post', 'click', publishWorkshop);
			addListener('.get-post', 'click', getPost);
			addListener('[data-t]', 'click', getTagArchive);
			addListener('.bookmark', 'click', bookmarkPost);
			addListener('.clone', 'click', clonePost);
			if (jQuery('.header-post input[name="title"]').length == 1) {
				jQuery('footer').addClass('d-none');
				jQuery('body').addClass('fixed-sidebar');
			}

			avatarInit();
			select2dropDown();
			bsValidatorInit();
			uppyUpLoader();
			// check if there's a create tab btn & there's no days created
			if (jQuery('.btn-days_wrapper a.tab').length > 0) {
				if (jQuery('.btn-days_wrapper .btn:not(.tab)').length < 1) {
					jQuery('.btn-days_wrapper a.tab').click();
				}
				var textContentWorkShop = document.querySelectorAll(
					'.workshop-input_content'
				);
				jQuery.each(textContentWorkShop, function (index, val) {
					autoExpand(val);
				});
			}
			// trigger change after load to put number in right sidebar
			if (jQuery('.workshop-input_number').length > 0) {
				jQuery('.workshop-input_number').trigger('change');
			}
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// comment
function addComment(e) {
	e.preventDefault();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var inputs = e.target.elements,
		post = e.target.dataset.post,
		parent =
			typeof e.target.dataset.parent != 'undefined'
				? e.target.dataset.parent
				: 0,
		side = hasClasse(e.target, 'side-comment') ? true : false,
		u = document.querySelector('body[data-u]').dataset.u,
		path = 'comment/',
		url = wpApiSettings.root + path,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': wpApiSettings.nonce,
			},
			body: JSON.stringify({
				content: inputs['comment'].value,
				post: post,
				parent: parent,
				u: u,
				side: side,
			}),
		};

	callLoading('on');

	fetch(url, request)
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
			if (data.html) {
				inputs['comment'].value = '';

				if (!side) {
					document
						.querySelector('.view-content__comments_container')
						.parentNode.replaceChild(
							document
								.createRange()
								.createContextualFragment(data.html),
							document.querySelector(
								'.view-content__comments_container'
							)
						);
				} else {
					document
						.querySelector('.sidebar-sticky-left')
						.parentNode.replaceChild(
							document
								.createRange()
								.createContextualFragment(data.html),
							document.querySelector('.sidebar-sticky-left')
						);
					jQuery('a[href="#commentsSidebar"]').click();
				}

				avatarInit();
				bsValidatorInit();
				uppyUpLoader();
				addListener('.get-profile', 'click', getProfile);
				addListener('.get-post', 'click', getPost);
				addListener('[data-t]', 'click', getTagArchive);
			}

			toastInit('success_toast', data.message);
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// get profile
function getProfile(e) {
	e.preventDefault();
	e.stopImmediatePropagation();
	e.stopPropagation();
	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var el = e.target.hasAttribute('data-p')
			? e.target
			: get_closest_parent(e.target, '[data-p]'),
		path = 'profile/',
		url = wpApiSettings.root + path,
		p = el.dataset.p,
		u = document.querySelector('body[data-u]').dataset.u,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': wpApiSettings.nonce,
			},
			body: JSON.stringify({
				u: u,
				p: p,
			}),
		};

	callLoading('on');

	fetch(url, request)
		.then(function (response) {
			callLoading('off', 'on');

			if (!response.ok) {
				// trigger catch block
				throw new Error(response.statusText);
			} else {
				return response.json();
			}
		})
		.then(function (data) {
			//console.log(data);
			addClasse(document.querySelector('body'), 'fixed-sidebar');
			main.innerHTML = data.html;
			nav.innerHTML = data.nav;

			addClasse(main, 'bg-mo-gray');

			addListener('[data-page]', 'click', getPage);
			addListener('.get-profile', 'click', getProfile);
			addListener('[data-archive]', 'click', getArchive);
			addListener('.bookmark', 'click', bookmarkPost);
			addListener('.get-post', 'click', getPost);
			addListener('.logout', 'click', logoutUser);
			addListener('.create-post', 'click', createPost);
			addListener('[data-t]', 'click', getTagArchive);
			avatarInit();
			select2dropDown();
			uppyUpLoader();
			bsValidatorInit();
			setWindowHistory(data.title, data.perma, url, request);
			if (jQuery('a[href="#groups"]').length == 1) {
				jQuery(document).on(
					'shown.bs.tab',
					'a[href="#groups"]',
					function (e) {
						if (
							jQuery(this)
								.parents('.content-section_header.tabs')
								.find('a[data-target="#newGroup"]').length == 1
						) {
							jQuery(this)
								.parents('.content-section_header.tabs')
								.find('a[data-target="#newGroup"]')
								.removeClass('d-none');
						}
					}
				);
				jQuery(document).on(
					'shown.bs.tab',
					'a[href="#bookmarked"], a[href="#posts"] , a[href="#settings"]',
					function (e) {
						if (
							jQuery(this)
								.parents('.content-section_header.tabs')
								.find('a[data-target="#newGroup"]').length == 1
						) {
							jQuery(this)
								.parents('.content-section_header.tabs')
								.find('a[data-target="#newGroup"]')
								.addClass('d-none');
						}
					}
				);
			}
			if (jQuery('.update-group').length == 1) {
				jQuery(document).on(
					'shown.bs.tab',
					'a[href="#settings"]',
					function (e) {
						jQuery('.update-group').removeClass('d-none');
					}
				);
				jQuery(document).on(
					'shown.bs.tab',
					'a[href="#groups"], a[href="#posts"]',
					function (e) {
						jQuery('.update-group').addClass('d-none');
					}
				);
			}
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// get archive
function getArchive(e) {
	e.preventDefault();
	e.stopImmediatePropagation();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var el = e.target.hasAttribute('data-archive')
			? e.target
			: get_closest_parent(e.target, '[data-archive]'),
		path = 'archive/',
		url = wpApiSettings.root + path,
		archive = el.dataset.archive,
		u = document.querySelector('body[data-u]').dataset.u,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				u: u,
				archive: archive,
			}),
		};

	callLoading('on');

	fetch(url, request)
		.then(function (response) {
			callLoading('off', 'on');

			if (!response.ok) {
				// trigger catch block
				throw new Error(response.statusText);
			} else {
				return response.json();
			}
		})
		.then(function (data) {
			//console.log(data);
			removeClasse(document.querySelector('body'), 'fixed-sidebar');
			if (document.querySelector('#nav_wrap .nav-link.active')) {
				removeClasse(
					document.querySelector('body'),
					'bg-' +
						document.querySelector('#nav_wrap .nav-link.active')
							.dataset.archive
				);
				removeClasse(
					document.querySelector('#nav_wrap .nav-link.active'),
					'active'
				);
			}
			addClasse(document.querySelector('body'), 'bg-' + archive);
			addClasse(document.querySelector('main'), 'bg-mo-gray');
			addClasse(el, 'active');
			main.innerHTML = data.html;

			setWindowHistory(data.title, data.perma, url, request);
			addListener('.get-profile', 'click', getProfile);
			addListener('.bookmark', 'click', bookmarkPost);
			addListener('.get-post', 'click', getPost);
			addListener('[data-load]', 'click', loadAllPosts);
			addListener('[data-t]', 'click', getTagArchive);
			avatarInit();
			select2dropDown();
			bsValidatorInit();
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// load all
function loadAllPosts(e) {
	e.preventDefault();
	e.stopImmediatePropagation();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var el = e.target.hasAttribute('data-load')
			? e.target
			: get_closest_parent(e.target, '[data-load]'),
		path = 'load-all/',
		url = wpApiSettings.root + path,
		type =
			el.dataset.load !== 'bookmarks'
				? JSON.parse(el.dataset.load)
				: el.dataset.load,
		cat = el.dataset.cat ? JSON.parse(el.dataset.cat) : false,
		u = document.querySelector('body[data-u]').dataset.u,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				u: u,
				type: type,
				cat: cat,
			}),
		};

	callLoading('on');

	fetch(url, request)
		.then(function (response) {
			callLoading('off', 'on');

			if (!response.ok) {
				// trigger catch block
				throw new Error(response.statusText);
			} else {
				return response.json();
			}
		})
		.then(function (data) {
			console.log(data);
			get_closest_parent(el, '.section-wrapper').querySelector(
				'.row'
			).innerHTML = data.html;

			jQuery(el)
				.parents('.section-wrapper')
				.siblings('.section-wrapper')
				.remove();
			jQuery(el).remove();

			addListener('.get-profile', 'click', getProfile);
			addListener('.bookmark', 'click', bookmarkPost);
			addListener('.get-post', 'click', getPost);
			addListener('[data-t]', 'click', getTagArchive);
			avatarInit();
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// bookmark post
function bookmarkPost(e) {
	e.preventDefault();
	e.stopImmediatePropagation();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var el = hasClasse(e.target, 'bookmark')
			? e.target
			: get_closest_parent(e.target, '.bookmark'),
		parent = get_closest_parent(el, '.card')
			? get_closest_parent(el, '.card')
			: get_closest_parent(el, '.view-content__container_header'),
		action = hasClasse(parent, 'bookmarked') ? false : true,
		path = 'bookmark/',
		url = wpApiSettings.root + path,
		b = el.dataset.b,
		u = document.querySelector('body[data-u]').dataset.u,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				u: u,
				b: b,
				action: action,
			}),
		};

	callLoading('on');

	fetch(url, request)
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
			if (data.data && data.data.status !== 200) {
				toastInit('error_toast', data.message);
			} else {
				if (action) {
					addClasse(parent, 'bookmarked');
				} else {
					removeClasse(parent, 'bookmarked');
					get_closest_parent(el, '.col-md-6').remove();
				}

				toastInit('success_toast', data.message);
			}
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// search
function getSearch(e) {
	e.preventDefault();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var inputs = e.target.elements,
		u = document.querySelector('body[data-u]').dataset.u,
		path = 'search/',
		url = wpApiSettings.root + path,
		types = [],
		request_body = {
			u: u,
		};

	for (var i = inputs.length - 1; i >= 0; i--) {
		if (inputs[i].type !== 'submit' && inputs[i].type !== 'checkbox') {
			request_body[inputs[i].name] = inputs[i].value;
		}

		if (inputs[i].type == 'checkbox') {
			if (inputs[i].checked && inputs[i].value !== 'all') {
				types.push(inputs[i].value);
			}
		}
	}

	request_body['types'] = types;

	var request = {
		method: 'POST',
		mode: 'same-origin',
		credentials: 'same-origin',
		signal: signal,
		headers: {
			'Content-Type': 'application/json',
			'X-WP-Nonce': wpApiSettings.nonce,
		},
		body: JSON.stringify(request_body),
	};

	callLoading('on');

	fetch(url, request)
		.then(function (response) {
			callLoading('off', 'on');

			if (!response.ok) {
				// trigger catch block
				throw new Error(response.statusText);
			} else {
				return response.json();
			}
		})
		.then(function (data) {
			console.log(data);
			main.innerHTML = data.html;
			setWindowHistory(data.title, data.perma, url, request);
			addListener('.get-profile', 'click', getProfile);
			addListener('.bookmark', 'click', bookmarkPost);
			addListener('.get-post', 'click', getPost);
			avatarInit();
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

function getSearchSide(e) {
	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	//console.log(e.target);

	var keyword = e.target.value,
		wrapper = document.getElementById('search_side_result'),
		u = document.querySelector('body[data-u]').dataset.u,
		path = 'search-side/',
		url = wpApiSettings.root + path,
		request_body = {
			u: u,
			keyword: keyword,
		};

	var request = {
		method: 'POST',
		mode: 'same-origin',
		credentials: 'same-origin',
		signal: signal,
		headers: {
			'Content-Type': 'application/json',
			'X-WP-Nonce': wpApiSettings.nonce,
		},
		body: JSON.stringify(request_body),
	};

	callLoading('on');

	fetch(url, request)
		.then(function (response) {
			callLoading('off', 'on');

			return response.json();
		})
		.then(function (data) {
			if (data.data && data.data.status !== 200) {
				toastInit('error_toast', data.message);
			} else {
				wrapper.innerHTML = data.html;
				addListener('.bookmark', 'click', bookmarkPost);
				addListener('.get-post', 'click', getPost);
				addListener('.get-profile', 'click', getProfile);
				addListener('[data-t]', 'click', getTagArchive);
				avatarInit();
			}
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// get tag archive
function getTagArchive(e) {
	e.preventDefault();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var el = e.target.hasAttribute('data-t')
			? e.target
			: get_closest_parent(e.target, '[data-t]'),
		tag = el.dataset.t,
		u = document.querySelector('body[data-u]').dataset.u,
		path = 'get-tag/',
		url = wpApiSettings.root + path,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': wpApiSettings.nonce,
			},
			body: JSON.stringify({
				u: u,
				tag: tag,
			}),
		};

	callLoading('on');

	fetch(url, request)
		.then(function (response) {
			callLoading('off', 'on');

			if (!response.ok) {
				// trigger catch block
				throw new Error(response.statusText);
			} else {
				return response.json();
			}
		})
		.then(function (data) {
			console.log(data);
			main.innerHTML = data.html;
			setWindowHistory(data.title, data.perma, url, request);
			addListener('.get-profile', 'click', getProfile);
			addListener('.bookmark', 'click', bookmarkPost);
			addListener('.get-post', 'click', getPost);
			addListener('[data-t]', 'click', getTagArchive);
			avatarInit();
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// update user
function updateUser(e) {
	e.preventDefault();
	e.stopImmediatePropagation();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var form = e.target,
		formData = new FormData();

	formData.append('u', document.querySelector('body[data-u]').dataset.u);
	formData.append(
		'fullname',
		form.querySelector('input[name="fullname"]').value
	);
	formData.append('email', form.querySelector('input[name="email"]').value);
	formData.append('bdate', form.querySelector('input[name="bdate"]').value);
	formData.append('desc', form.querySelector('textarea[name="desc"]').value);

	if (window.userPhoto) {
		window.userPhoto.getFiles().length !== 0
			? formData.append('userPhoto', window.userPhoto.getFiles()[0].data)
			: formData.append('userPhoto', false);
	} else {
		formData.append('userPhoto', false);
	}

	var u = document.querySelector('body[data-u]').dataset.u,
		path = 'update-user/',
		url = wpApiSettings.root + path,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			body: formData,
		};

	fetch(url, request)
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
			toastInit('success_toast', data.message);
			console.log(data);
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// upload post attachments
function uploadAttach(e) {
	e.preventDefault();
	e.stopImmediatePropagation();
	//console.log(e);

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var post = document.getElementById('pc').dataset.post,
		formData = new FormData();

	formData.append('u', document.querySelector('body[data-u]').dataset.u);
	formData.append('p', post);

	if (window.attachPc) {
		window.attachPc.getFiles().length !== 0
			? formData.append('postAttach', window.attachPc.getFiles()[0].data)
			: formData.append('postAttach', false);
	} else {
		formData.append('postAttach', false);
	}
	var path = 'upload-attach/',
		url = wpApiSettings.root + path,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			body: formData,
		};

	callLoading('on');


	fetch(url, request)
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
			toastInit('success_toast', data.message);
			jQuery('.wrapper-file-added').remove();
			if(!data.type){
				data.type='Link';
			}
			if(data.name==''){
				data.name='Link';
			}
			if(!data.size){
				data.size=1;
			}

			
			var addedFile = jQuery(
				'<div class="file-added uploaded"><p class="exe">' +
					data.type +
					'</p><div><div><p>' +
					data.name +
					'</p><span>' +
					Math.round(data.size / 1024) +
					' kb</span></div></div></div>'
			);
			jQuery('#attach_list').append(addedFile);
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}
function addAttachLink(link,name){
    var addedFile = jQuery(
        '<a href="'+link+'" class="file-added uploaded" target="_blank"><p class="exe">Link</p><div><div><p>'+name + '</p><span>1 kb</span></div></div></a>'
    );
    jQuery('#attach_list').append(addedFile);
    jQuery.ajax({
        type: "POST",
        data: { ajax: 10, attachLink: link,  attachName: name}
    }).done(function( msg ) { 
        alert('success');
    });
}

// read all notification
function notifiReadAll(e) {
	e.preventDefault();
	e.stopImmediatePropagation();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var u = document.querySelector('body[data-u]').dataset.u,
		path = 'read-notification/',
		url = wpApiSettings.root + path,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': wpApiSettings.nonce,
			},
			body: JSON.stringify({
				u: u,
			}),
		};

	fetch(url, request)
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
			jQuery(e.target)
				.siblings('.dropdown-notifitctions')
				.find('.dropdown-item ')
				.addClass('seen');
				document.querySelector('.icon-Notifi-Badge').classList.add('d-none');
			// toastInit('success_toast', data.message);
			// console.log(data);
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}

// add material
function addMaterial(e) {
	e.preventDefault();
	e.stopImmediatePropagation();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var inputs = e.target.elements,
		table = jQuery(e.target).siblings('.table-responsive'),
		post = e.target.dataset.post,
		formData = new FormData();

	formData.append('u', document.querySelector('body[data-u]').dataset.u);
	formData.append('p', post);

	for (var i = inputs.length - 1; i >= 0; i--) {
		if (inputs[i].type !== 'submit') {
			formData.append(inputs[i].name, inputs[i].value);
		}
	}

	if (table.length == 0) {
		table = jQuery(
			'<div class="table-responsive p-4"><table class="table table-bordered table-striped"><thead><tr><th scope="col"></th><th scope="col">البند</th><th scope="col">العدد</th></tr></thead><tbody></tbody></table></div>'
		);
		table.insertAfter(jQuery(e.target));
	}

	var path = 'add-material/',
		url = wpApiSettings.root + path,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			body: formData,
		};

	callLoading('on');

	fetch(url, request)
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
			toastInit('success_toast', data.message);

			var tbody = table.find('tbody');

			tbody.append(
				'<tr><td><i class="icon-delete"></i></td><td>' +
					data.title +
					'</td><td><div class="d-flex justify-content-center align-items-center flex-column">' +
					data.number +
					'</div></td></tr>'
			);
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}
function removeMatrial(e) {
	e.preventDefault();
	e.stopImmediatePropagation();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var post = e.target.dataset.post,
		deletedItem = e.target.dataset.material,
		formData = new FormData();

		console.log(post);

	formData.append('u', document.querySelector('body[data-u]').dataset.u);
	formData.append('p', post);
	formData.append('deleted', deletedItem);


	var path = 'remove-material/',
		url = wpApiSettings.root + path,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			body: formData,
		};

	callLoading('on');

	fetch(url, request)
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
			toastInit('success_toast', data.message);
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				toastInit('error_toast', error);
			}
		});
}

// clone post
function clonePost(e) {
	e.preventDefault();
	e.stopImmediatePropagation();

	// aport any onging fetch ex: loadMore
	if (controller) {
		controller.abort();
	}

	controller = new AbortController();
	var signal = controller.signal;

	var el = hasClasse(e.target, 'clone')
			? e.target
			: get_closest_parent(e.target, '.clone'),
		path = 'clone/',
		url = wpApiSettings.root + path,
		c = el.dataset.c,
		u = document.querySelector('body[data-u]').dataset.u,
		request = {
			method: 'POST',
			mode: 'same-origin',
			credentials: 'same-origin',
			signal: signal,
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				u: u,
				c: c,
			}),
		};

	callLoading('on');

	fetch(url, request)
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
			if (data.data && data.data.status !== 200) {
				toastInit('error_toast', data.message);
			} else {
				toastInit('success_toast', data.message);
				window.history.pushState('', '', data.url);
				window.location.reload();
			}
		})
		.catch(function (error) {
			if (error.name !== 'AbortError') {
				console.log(error);
				toastInit('error_toast', error);
			}
		});
}


