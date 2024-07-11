import { ComponentContent, FieldContent } from "../entities/ComponentContent";
import {
  ComponentFieldStructure,
  ComponentStructure,
} from "../entities/ComponentStructure";
import { findComponentById, findComponentStructure } from "../utils/finder";

import { BlockContent } from "../entities/BlockContent";
import { BlockStructure } from "../entities/BlockStructure";
import { Repeater } from "../entities/Repeater";
import { buildNewSingleComponentFromStructure } from "../utils/builder";

export const addComponent = (
  zoneStore,
  blockId: string,
  rootId: string,
  componentStructureId: string
) => {
  console.debug("coucou");
  const blockIndex = zoneStore.content.findIndex(
    (block: BlockContent) => block.id === blockId
  );
  const blockContent: BlockContent = zoneStore.content[blockIndex];
  const blockStructure: BlockStructure = zoneStore.getBlockStructure(blockId);
  const componentStructure: ComponentStructure = findComponentStructure(
    blockStructure,
    componentStructureId
  );
  const componentContent: ComponentContent | Repeater<ComponentContent> =
    buildNewSingleComponentFromStructure(componentStructure);
  const newBlockContent = insertNewComponent(
    blockContent,
    componentContent,
    rootId
  );
  zoneStore.content[blockIndex] = newBlockContent;
  return 2;
};

const insertNewComponent = (
  content: BlockContent | ComponentContent,
  newComponentContent: ComponentContent,
  rootId: string
): BlockContent | ComponentContent => {
  const { node: foundComponent } = findComponentById(content, rootId);
  if ((foundComponent as FieldContent).type !== "repeater")
    throw new Error("Cannot insert component into non repeater parent");
  (foundComponent as Repeater<ComponentContent>).sub_elements.push(
    newComponentContent
  );
  console.log(content);
  return content;
};
