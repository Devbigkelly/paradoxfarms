const accordion1 = document.querySelector('.accordion1')
const accordionContent1 = document.querySelector('.content1')

const accordion2 = document.querySelector('.accordion2')
const accordionContent2 = document.querySelector('.content2')


const accordion3 = document.querySelector('.accordion3')
const accordionContent3 = document.querySelector('.content3')


const accordion4 = document.querySelector('.accordion4')
const accordionContent4 = document.querySelector('.content4')

const arrow = document.querySelector('#arrow-1')
const arrow2 = document.querySelector('#arrow-2')
const arrow3 = document.querySelector('#arrow-3')
const arrow4 = document.querySelector('#arrow-4')

    accordion1.addEventListener('mousedown',()=>{
        accordionContent1.style.maxHeight = '120px'
        accordionContent1.style.transition = '0.2s linear'
        accordion1.style.backgroundColor = 'green'
        arrow.innerHTML = `<i class="fa-solid fa-arrow-down"></i> `
    })

    accordion1.addEventListener('mouseup',()=>{
        accordionContent1.style.maxHeight = '0px'
        accordionContent1.style.transition = '0.2s linear'
        accordion1.style.backgroundColor = '#D9D9D9'
        arrow.innerHTML = `<i class="fa-solid fa-arrow-up"></i>`
    })


    accordion2.addEventListener('mousedown',()=>{
        accordionContent2.style.maxHeight = '150px'
        accordionContent2.style.transition = '0.2s linear'
        accordion2.style.backgroundColor = 'green'
        arrow2.innerHTML = `<i class="fa-solid fa-arrow-down"></i> `

    })

    accordion2.addEventListener('mouseup',()=>{
        accordionContent2.style.maxHeight = '0px'
        accordionContent2.style.transition = '0.2s linear'
        accordion2.style.backgroundColor = '#D9D9D9'
        arrow2.innerHTML = `<i class="fa-solid fa-arrow-up"></i>`

    })

    accordion3.addEventListener('mousedown',()=>{
        accordionContent3.style.maxHeight = '150px'
        accordionContent3.style.transition = '0.2s linear'
        accordion3.style.backgroundColor = 'green'
        arrow3.innerHTML = `<i class="fa-solid fa-arrow-down"></i> `

    })

    accordion3.addEventListener('mouseup',()=>{
        accordionContent3.style.maxHeight = '0px'
        accordionContent3.style.transition = '0.2s linear'
        accordion3.style.backgroundColor = '#D9D9D9'
        arrow3.innerHTML = `<i class="fa-solid fa-arrow-up"></i>`
    })

    accordion4.addEventListener('mousedown',()=>{
        accordionContent4.style.maxHeight = '150px'
        accordionContent4.style.transition = '0.2s linear'
        accordion4.style.backgroundColor = 'green'
        arrow4.innerHTML = `<i class="fa-solid fa-arrow-down"></i> `

    })

    accordion4.addEventListener('mouseup',()=>{
        accordionContent4.style.maxHeight = '0px'
        accordionContent4.style.transition = '0.2s linear'
        accordion4.style.backgroundColor = '#D9D9D9'
        arrow4.innerHTML = `<i class="fa-solid fa-arrow-up"></i>`

    })

