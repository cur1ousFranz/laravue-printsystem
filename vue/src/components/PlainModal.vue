<template>
    <transition name="modal-fade">
        <div class="modal-backdrop" @click.self="close">
            <div class="modal">
                <header class="modal-header text-2xl font-bold">
                    <slot name="header">
                        This is the default title!
                    </slot>
                </header>

                <section class="modal-body">
                    <slot name="body">
                    This is the default body!
                    </slot>
                </section>

                <footer class="modal-footer">
                    <div class="flex justify-end space-x-3">
                        <button class="px-3 py-2 border border-gray-900 text-gray-900 text-sm" type="button" @click="close" >
                            Close
                        </button>
                    </div>
                </footer>
            </div>
        </div>
    </transition>
</template>

<script>
  export default {
    name: 'Modal',
    methods: {
      close() {
        this.$emit('close');
      },
    },
  };
</script>

<style scoped>
  .modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal {
    background: #FFFFFF;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
    width: 50%;

  }

  .modal-header {
    padding: 35px;
    display: flex;
    text-align: center;
  }

    .modal-footer {
    padding: 15px;
    display: flex;
    text-align: center;
  }

  .modal-header {
    position: relative;
    justify-content: center;
  }

  .modal-footer {
    border-top: 1px solid #eeeeee;
    flex-direction: column;
    justify-content: flex-end;
  }

  .modal-body {
    position: relative;
    padding: 20px 30px;
    overflow-y: auto;
    max-height: 400px;
  }

    .modal-fade-enter,
  .modal-fade-leave-to {
    opacity: 0;
  }

  .modal-fade-enter-active,
  .modal-fade-leave-active {
    transition: opacity .5s ease;
  }
</style>
