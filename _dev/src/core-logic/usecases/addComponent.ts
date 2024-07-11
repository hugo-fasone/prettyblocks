import {
  ComponentFieldStructure,
  ComponentStructure,
} from "../entities/ComponentStructure";

import { BlockContent } from "../entities/BlockContent";
import { BlockStructure } from "../entities/BlockStructure";
import { ComponentContent } from "../entities/ComponentContent";
import { Repeater } from "../entities/Repeater";
import { buildNewSingleComponentFromStructure } from "../utils/builder";

export const addComponent = (
  zoneStore,
  blockIndex: number,
  componentId: string
) => {
  console.debug("Coucou");
  const blockStructure: BlockStructure = zoneStore.getBlockStructure(
    zoneStore.content[blockIndex].block_id
  );
  const blockContent: BlockContent = zoneStore.content[blockIndex];
  const componentStructure: ComponentStructure = findBlockStructure(
    blockStructure,
    componentId
  );
  console.debug("Structure found : " + componentStructure);
  const componentContent: ComponentContent | Repeater<ComponentContent> =
    buildNewSingleComponentFromStructure(componentStructure);
  const newBlockContent = insertNewComponent(
    blockContent,
    componentContent,
    componentId
  );
  zoneStore.content[blockIndex] = newBlockContent;
};

const findBlockStructure = (
  structure: BlockStructure | ComponentStructure,
  componentId: string
): ComponentStructure => {
  return Object.values(structure.fields).find(
    (field: ComponentFieldStructure) => {
      if (field.type !== "component") return false;
      return field.id === componentId;
    }
  ) as ComponentStructure;
};

const insertNewComponent = (
  content: BlockContent | ComponentContent,
  newComponentContent: ComponentContent,
  componentId: string
): BlockContent | ComponentContent => {
  const repeater = content.fields.find((field) => {
    if (field.type !== "repeater") return false;
    field.component_id === componentId;
  }) as Repeater<ComponentContent>;
  repeater.sub_elements.push(newComponentContent);
  console.debug(content);
  return content;
};
