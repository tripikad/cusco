<template>

    <div>
        
        <div class="Editor" :class="isclasses">

            <div class="Editor__toolbar">

                <div class="Editor__tool" @click="insertBold()">B</div>
                <div class="Editor__tool" @click="insertItalic()">I</div>
                <div class="Editor__tool" @click="insertMarkdownLink()">Link</div>
                <div class="Editor__tool" @click="insertHeading()">H1</div>
                <div class="Editor__tool" @click="insertTable()">▦</div>
                <div class="Editor__tool" @click="cleanMarkup()">Clean</div>
                <div class="Editor__tool" @click="toggleImagebrowser()">Image</div>

            </div>

            <div class="Editor__wrapper">

                <div v-el:writer class="Editor__writer" id="writer"></div>
                
                <div class="Editor__preview">

                    <div class="Body">
                    
                    {{{ body }}}

                    </div>

                </div>

            </div>

       </div>

       <div class="Editor__imagebrowser" v-if="imagebrowserOpen">
            
            <component is="ImageUpload"></component>

           <div v-for="image in images">
           
               <img :src="image" width="20%" @click="insertImage($key)">

           </div>

       </div>

   </div>

</template>

<script>

    import brace from 'brace'
    import _ from 'lodash'
    import tomarkdown from 'to-markdown'
    import striptags from 'striptags'

    import 'brace/theme/chrome'
    import 'brace/mode/markdown'

    import ImageUpload from '../ImageUpload/ImageUpload.vue'

    export default {

        components: {
            ImageUpload
        },

        data() {
            return {
                body: '',
                images: [],
                editor: {},
                imagebrowserOpen: false
            }
        },

        ready: function() {
            this.editor = brace.edit(this.$els.writer)
            this.editor.setTheme('ace/theme/chrome')
            this.editor.getSession().setMode('ace/mode/markdown')
            this.editor.renderer.setShowGutter(false)
            this.editor.setHighlightActiveLine(false)
            this.editor.setOption('wrap', 60)
            this.editor.$blockScrolling = Infinity
            this.editor.setValue(this.body)

            this.editor.getSession().on('change', function() {
                this.updatePreview()
            }.bind(this))

            this.updateImages()
        },

        events: {

            'imageUploaded': function() {
                this.updateImages()
            }

        },

        methods: {

            updatePreview: function() {
                this.$http.post('./render', {body: this.editor.getValue()})
                    .then(function(res) {
                        this.body = res.data.body
                    })
            },

            updateImages: function() {
                this.$http.get('image/index').then(function(res) {
                    this.images = res.data
                })
            },

            insertBold: function() {
                this.editor.getSession().replace(
                    this.editor.selection.getRange(),
                    '**' + this.editor.getSelectedText() + '**'
                )
                this.editor.focus()
            },

            insertItalic: function() {
                this.editor.getSession().replace(
                    this.editor.selection.getRange(),
                    '*' + this.editor.getSelectedText() + '*'
                )
                this.editor.focus()
            },

            insertMarkdownLink: function() {
                var link = window.prompt('Link URL', 'http://')
                this.editor.getSession().replace(
                    this.editor.selection.getRange(),
                    '[' + this.editor.getSelectedText() + '](' + link + ')'
                )
                this.editor.focus()
            },

            insertHeading: function() {
                this.editor.getSession().replace(
                    this.editor.selection.getRange(),
                    '\n#### ' + this.editor.getSelectedText()
                )
                this.editor.focus()
            },

            insertTable: function() {
                this.editor.getSession().replace(
                    this.editor.selection.getRange(), [
                        '| Veerg 1 | Veerg 2 | Veerg 3 |',
                        '|---------|---------|---------|',
                        '| Sisu 1  | Sisu 2  | Sisu 3  |',
                        '\n'
                    ].join('\n')
                )
                this.editor.focus()
            },

            cleanMarkup: function() {
                var body = this.body
                body = body.replace(/&nbsp;/g, ' ')
                body = _.unescape(body)
                body = striptags(body,
                    '<b><i><strong><em><a><br><ul><ol><li><img><iframe><h4><h5><h6><p>'
                )
                body = tomarkdown(body)
                this.editor.setValue(body)
                this.editor.focus()
            },

            toggleImagebrowser: function() {
                this.imagebrowserOpen = !this.imagebrowserOpen
            },

            insertImage: function(key) {
                this.editor.getSession().replace(
                    this.editor.selection.getRange(),
                    '\n\n[[' + key + ']]\n\n'
                )
                this.imagebrowserOpen = false
                this.editor.focus()
            }
        }

    }

</script>