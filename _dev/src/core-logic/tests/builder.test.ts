import {
  buildNewBlockContentFromBlockStructure,
  buildNewComponentFromStructure,
  buildNewPrimitiveFieldFromStructure,
} from "../utils/builder";

import { BlockContent } from "../entities/BlockContent";
import { BlockStructure } from "../entities/BlockStructure";
import { ComponentContent } from "../entities/ComponentContent";
import { ComponentStructure } from "../entities/ComponentStructure";
import { PrimitiveFieldContent } from "../entities/PrimitiveFieldContent";
import { PrimitiveFieldStructure } from "../entities/PrimitiveFieldStructure";
import { PrimitiveFieldType } from "../entities/ElementType";
import { Repeater } from "../entities/Repeater";
import columnBlockContent from "./newColumnContent.json";
import columnBlockStructure from "./columnStructure.json";

/* 
  Add a test here everytime you create a new builder or improve an existing one.
*/

describe("Block, component and Primitive content builder", () => {
  let blockStructure: BlockStructure;
  let blockContent: BlockContent;
  beforeAll(() => {
    blockStructure = columnBlockStructure as BlockStructure;
    blockContent = columnBlockContent as BlockContent;
  });

  describe("Primitive builder", () => {
    it("builds a primitive text", () => {
      const primitiveTextStructure: PrimitiveFieldStructure<PrimitiveFieldType.TEXT> =
        blockStructure.fields
          .title as PrimitiveFieldStructure<PrimitiveFieldType.TEXT>;
      const expectedTextContent: PrimitiveFieldContent<PrimitiveFieldType.TEXT> =
        blockContent
          .fields[0] as PrimitiveFieldContent<PrimitiveFieldType.TEXT>;
      const newTextContent: PrimitiveFieldContent<PrimitiveFieldType.TEXT> =
        buildNewPrimitiveFieldFromStructure(
          primitiveTextStructure
        ) as PrimitiveFieldContent<PrimitiveFieldType.TEXT>;
      expect(newTextContent).toHaveProperty("id");
      expect(newTextContent).toHaveProperty("label", expectedTextContent.label);
      expect(newTextContent).toHaveProperty("type", expectedTextContent.type);
      expect(newTextContent).toHaveProperty(
        "content.value",
        expectedTextContent.content.value
      );
    });
  });

  describe("Component builder", () => {
    it("builds a non-repeatable component", () => {
      const componentStructure: ComponentStructure = blockStructure.fields
        .banner as ComponentStructure;
      const expectedComponentContent: ComponentContent = blockContent
        .fields[1] as ComponentContent;
      const newComponentContent: ComponentContent =
        buildNewComponentFromStructure(componentStructure) as ComponentContent;
      expect(newComponentContent).toHaveProperty("id");
      expect(newComponentContent).toHaveProperty(
        "label",
        expectedComponentContent.label
      );
      expect(newComponentContent).toHaveProperty(
        "type",
        expectedComponentContent.type
      );
      expect(newComponentContent).toHaveProperty(
        "component_id",
        expectedComponentContent.component_id
      );
      expect(newComponentContent).toHaveProperty("fields");
    });
    it("fills non-repeatable component fields with default values", () => {
      const componentStructure: ComponentStructure = blockStructure.fields
        .banner as ComponentStructure;
      const expectedComponentContentFields = (
        blockContent.fields[1] as ComponentContent
      ).fields;
      const newComponentContent: ComponentContent =
        buildNewComponentFromStructure(componentStructure) as ComponentContent;
      const newComponentFields = newComponentContent.fields;
      expect(newComponentFields[0]).toHaveProperty("id");
      expect(newComponentFields[0]).toHaveProperty(
        "type",
        expectedComponentContentFields[0].type
      );
      expect(newComponentFields[0]).toHaveProperty(
        "label",
        expectedComponentContentFields[0].label
      );
      expect(newComponentFields[0]).toHaveProperty(
        "content.value",
        (
          expectedComponentContentFields[0] as PrimitiveFieldContent<PrimitiveFieldType.TEXT>
        ).content.value
      );
      expect(newComponentFields[1]).toHaveProperty("id");
      expect(newComponentFields[1]).toHaveProperty(
        "type",
        expectedComponentContentFields[1].type
      );
      expect(newComponentFields[1]).toHaveProperty(
        "label",
        expectedComponentContentFields[1].label
      );
      expect(newComponentFields[1]).toHaveProperty(
        "content.value",
        (
          expectedComponentContentFields[1] as PrimitiveFieldContent<PrimitiveFieldType.TEXT>
        ).content.value
      );
    });
    it("builds a repeatable component", () => {
      const componentStructure: ComponentStructure = blockStructure.fields
        .columns as ComponentStructure;
      const expectedComponentContent: Repeater<ComponentContent> = blockContent
        .fields[2] as Repeater<ComponentContent>;
      const newComponentContent: Repeater<ComponentContent> =
        buildNewComponentFromStructure(
          componentStructure
        ) as Repeater<ComponentContent>;
      expect(newComponentContent).toHaveProperty("id");
      expect(newComponentContent).toHaveProperty(
        "label",
        expectedComponentContent.label
      );
      expect(newComponentContent).toHaveProperty(
        "type",
        expectedComponentContent.type
      );
      expect(newComponentContent).toHaveProperty(
        "component_id",
        expectedComponentContent.component_id
      );
      expect(newComponentContent).toHaveProperty(
        "sub_elements",
        expectedComponentContent.sub_elements
      );
    });
  });

  describe("Block builder", () => {
    it("builds a full block", () => {
      const newBlockContent: BlockContent =
        buildNewBlockContentFromBlockStructure(blockStructure);
      expect(newBlockContent).toHaveProperty("id");
      expect(newBlockContent).toHaveProperty("block_id", blockContent.block_id);
      expect(newBlockContent.fields).toHaveLength(3);
      expect(newBlockContent.fields[0]).toHaveProperty(
        "label",
        blockContent.fields[0].label
      );
      expect(newBlockContent.fields[1]).toHaveProperty(
        "label",
        blockContent.fields[1].label
      );
      expect(newBlockContent.fields[2]).toHaveProperty(
        "label",
        blockContent.fields[2].label
      );
    });
  });
});
