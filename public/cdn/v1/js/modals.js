import '../assets/modals.scss';
import 'formeo/dist/formeo.min'
window.CBU_GLOBAL = require('./forms.json');


const MODAL_CONFIG = {
    CLASSES: {
        MODAL: 'cbu-modal',
        MODAL_HIDE: 'cbu-modal--hide',
        MODAL_SHOW: 'cbu-modal--show',
        MODAL_WRAPPER: 'cbu-modal__wrapper',
        MODAL_CONTENT: 'cbu-modal-content'
    },

    EVENTS: {
        CREATED: 'cbu.modal.created',
        BEFORE_OPEN: 'cbu.modal.before-open',
        OPENED: 'cbu.modal.opened',
        BEFORE_CLOSE: 'cbu.modal.before-close',
        CLOSED: 'cbu.modal.closed'
    }
}

function render(tag, options, childrens) {
    const el = document.createElement(tag);

    if (typeof options === 'object') {

        if (options.hasOwnProperty('attrs')) {
            for (let key in options.attrs) {
                el.setAttribute(key, options.attrs[key]);
            }
        }

        if (options.hasOwnProperty('style')) {
            for (let key in options.style) {
                el.style[key] = options.style[key];
            }
        }

        if (options.hasOwnProperty('dataset')) {
            for (let key in options.dataset) {
                el.dataset[key] = options.dataset[key];
            }
        }


        if (options.hasOwnProperty('events')) {
            for (let key in options.events) {
                el.addEventListener(key, options.events[key])
            }
        }
    }

    if (childrens) {
        if (Array.isArray(childrens)) {
            childrens.map(child => {
                appendChildren(child)
            })
        } else {
            console.warn('Childrens must be an array!');
        }
    }

    function appendChildren(child) {
        if (typeof child === 'string') {
            el.innerHTML = child;
        } else {
            el.appendChild(child);
        }
    }

    return el;
}

export class Modal {
    constructor(options = { name: 'modal' }) {
        this.events = {};
        this.el = null;

        const _modal = {
            visible: false,
            appearTimeOutID: null,

            get isVisible() {
                if (this.appearTimeOutID) {
                    clearTimeout(this.appearTimeOutID);
                    resetTimer();
                }

                return this.visible;
            },

            set isVisible(newValue) {
                this.visible = newValue;
            }
        };

        const self = this;

        const createEvents = function () {

            for (let key in MODAL_CONFIG.EVENTS) {
                this.events[MODAL_CONFIG.EVENTS[key]] = new CustomEvent(MODAL_CONFIG.EVENTS[key])
            }

        }.bind(this)

        function create() {

            const modalContent = render('div', {
                attrs: {
                    class: MODAL_CONFIG.CLASSES.MODAL_CONTENT,
                    style: options.modalContentStyle
                },
                events: {
                    click(e) {
                        e.stopPropagation();
                    }
                }
            }, [options.modalContent]);

            const modalWrapper = render('div', {
                attrs: {
                    class: MODAL_CONFIG.CLASSES.MODAL_WRAPPER,
                    role: 'document'
                },
                events: {
                    transitionend(e) {
                        e.stopPropagation();
                    }
                }
            }, [modalContent]);

            const modal = render('div', {
                attrs: {
                    class: MODAL_CONFIG.CLASSES.MODAL + ' ' + MODAL_CONFIG.CLASSES.MODAL_HIDE,
                    role: 'dialog',
                    tabindex: "-1",
                },
                dataset: {
                    name: options.name
                },
                style: {
                    display: 'none'
                },
                events: {
                    click(e) {
                        self.hide();
                    },
                    transitionend(e) {
                        if (!_modal.isVisible) {
                            self.el.dispatchEvent(self.events[MODAL_CONFIG.EVENTS.OPENED]);
                        } else {
                            self.el.style.display = 'none';
                            self.el.dispatchEvent(self.events[MODAL_CONFIG.EVENTS.CLOSED])
                        }
                        _modal.isVisible = !_modal.visible;
                    }
                }
            }, [modalWrapper]);

            return document.body.appendChild(modal);
        }

        this.hide = function () {
            self.el.dispatchEvent(self.events[MODAL_CONFIG.EVENTS.BEFORE_CLOSE])

            self.el.classList.remove(MODAL_CONFIG.CLASSES.MODAL_SHOW);
            self.el.classList.add(MODAL_CONFIG.CLASSES.MODAL_HIDE);
        }

        this.show = function () {
            self.el.setAttribute('style', 'display: flex');

            self.el.dispatchEvent(self.events[MODAL_CONFIG.EVENTS.BEFORE_OPEN]);

            setTimeout(() => {
                self.el.classList.add(MODAL_CONFIG.CLASSES.MODAL_SHOW);
                self.el.classList.remove(MODAL_CONFIG.CLASSES.MODAL_HIDE);
            }, 0)
        }

        function appearIn(time = 0) {
            let appearAt = +localStorage.getItem(`cbu.${options.name}.appearAt`);
            let currentTime = new Date().getTime();

            if (appearAt) {
                return (appearAt - currentTime) >= 0 ? appearAt - currentTime : 0;
            } else {
                appearAt = currentTime + time;
                time && localStorage.setItem(`cbu.${options.name}.appearAt`, appearAt);
                return time;
            }
        }

        function resetTimer() {
            localStorage.removeItem(`cbu.${options.name}.appearAt`);
        }

        function checkUrlAppear() {
            if (!options.openOnUrls.length) return true;
            return options.openOnUrls.some(url => location.href === url);
        }

        function run() {

            if (options.openTrigger === 'time') {
                _modal.appearTimeOutID = setTimeout(() => {
                    self.show();
                    resetTimer();
                }, appearIn(options.openIn));
            }

            else if (options.openTrigger === 'modal') {

            }

            else if (options.openTrigger === 'click') {

            }
        }

        const init = function () {
            createEvents();

            this.el = create();
            this.el.dispatchEvent(this.events[MODAL_CONFIG.EVENTS.CREATED]);

            run();

        }.bind(this)

        if (checkUrlAppear()) {
            init();
        }
    }

    // subscribe to modal lifecycle events
    on(event, fn) {
        if (!this.el) return;
        this.el.addEventListener(event, fn);
    }
}

// const modalOne = new Modal({
//     name: 'cbu-modal-1',
//     appearIn: 1000 * 3,
//     appearUrl: 'http://localhost:8080/about',
//     modalContent: '<p>Modal one</p>'
// });

// const modalTwo = new Modal({
//     name: 'cbu-modal-2',
//     // appearIn: 1000 * 3,
//     appearUrl: 'http://localhost:8080/',
//     modalContent: '<p>Modal two</p>'
// });

// modalOne.on('cbu.modal.before-open', () => {
//     modalTwo.hide()
// })

// modalTwo.on('cbu.modal.before-open', () => {
//     modalOne.hide()
// })


let data = window.CBU_GLOBAL.config;

const forms = data.widget.tip_13_forms;
const key = data.widget.key;
const path = data.path.formMail;

const modals = {};

forms.map((form, i) => {
    let modalID = `wistismodal${form.id}`
    let formID = `wistisform${form.id}`;

    const modal = new Modal({
        name: modalID,
        openOnUrls: form.openOnUrls,
        openTrigger: form.openTrigger,
        openIn: form.openIn,
        modalContentStyle: form.formWrapperStyle,
        modalContent: form.formHtml
    });

    modals[modalID] = modal;

    setTimeout(() => {
        let button = document.querySelector(`[data-target="${modalID}"]`)
        if (button) button.addEventListener('click', modal.show);
    }, 0)

    let nodeForm = document.querySelector(`#${formID}`);
    if (nodeForm) {
        nodeForm.addEventListener('reset', modal.hide)
        nodeForm.addEventListener('submit', (e) => {
            e.preventDefault();

            let formData = new FormData(this);

            ajax(formData, path + '?key=' + key).then(() => {
                console.log('sent')
            });

            if (form.triggerModal && modals[`wistismodal${form.triggerModal}`]) {
                modal.hide();
                modals[`wistismodal${form.triggerModal}`].show();
            }
        })
    }

})


function ajax(data, url) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.onreadystatechange = function (e) {
            if (xhr.status === 200) resolve()
            else reject()
        }
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(data);

    })

}