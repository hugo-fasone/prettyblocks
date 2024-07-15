import { BlockStructure } from "./../entities/BlockStructure";
import { PrimitiveFieldContentMap } from "../entities/PrimitiveFieldContent";
import { PrimitiveFieldType } from "../entities/ElementType";
import { ZoneState } from "../entities/PageState";
import { addBlock } from "../usecases/addBlock";
import { addComponent } from "../usecases/addComponent";
import { defineStore } from "pinia";
import { deleteBlockById } from "../usecases/deleteBlock";
import { deleteComponentById } from "../usecases/deleteComponent";
import { editPrimitiveField } from "../usecases/editPrimitiveField";
import { moveBlock } from "../usecases/moveBlock";
import { moveComponent } from "../usecases/moveComponent";

export const useZoneStore = defineStore("zone", {
  state: (): ZoneState => {
    return {
      availableBlocks: [],
      content: [],
    };
  },
  getters: {
    getBlockStructure: (state) => {
      return (blockId: string) => {
        return state.availableBlocks.find(
          (block: BlockStructure) => block.id === blockId
        );
      };
    },
  },
  actions: {
    addBlock(blockId: string) {
      addBlock(this, blockId);
    },
    moveBlock(blockId: string, newIndex: number) {
      moveBlock(this, blockId, newIndex);
    },
    deleteBlockById(blockId: string) {
      deleteBlockById(this, blockId);
    },
    addComponent(blockId: string, root: string, componentId: string) {
      addComponent(this, blockId, root, componentId);
    },
    deleteComponentById(componentId: string) {
      deleteComponentById(this, componentId);
    },
    moveComponent(componentId: string, newIndex: number) {
      moveComponent(this, componentId, newIndex);
    },
    editPrimitiveField<T extends PrimitiveFieldType>(
      componentId: string,
      newValue: PrimitiveFieldContentMap[T]
    ) {
      editPrimitiveField(this, componentId, newValue);
    },
  },
});
